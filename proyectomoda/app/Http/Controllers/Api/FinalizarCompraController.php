<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\carrito;
use App\Models\cliente;
use App\Models\ordene;
use App\Models\ordenitem;
use App\Models\pagoordene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class FinalizarCompraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'paypal_order_id' => 'required|string',
            'paypal_status' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($request->paypal_status !== 'COMPLETED') {
            return response()->json([
                'message' => 'El pago no fue completado'
            ], 422);
        }

        $usuario = JWTAuth::parseToken()->authenticate();

        $cliente = cliente::firstOrCreate(
            ['usuario_id' => $usuario->id],
            ['direccion' => 'Sin dirección']
        );

        $carrito = carrito::with('producto')
            ->where('cliente_id', $cliente->id)
            ->get();

        if ($carrito->isEmpty()) {
            return response()->json([
                'message' => 'El carrito está vacío'
            ], 422);
        }

        $orden = DB::transaction(function () use ($request, $cliente, $usuario, $carrito) {

            $total = $request->total;

            $orden = ordene::create([
                'cliente_id' => $cliente->id,
                'numero_orden' => 'ORD-' . time(),
                'estado' => 'pagada',
                'total' => $total,
                'direccion_envio' => $cliente->direccion ?? 'Sin dirección',
                'telefono' => $usuario->tel ?? 'Sin teléfono',
                'notas' => 'Pago PayPal: ' . $request->paypal_order_id,
            ]);

            foreach ($carrito as $item) {
                ordenitem::create([
                    'orden_id' => $orden->id,
                    'producto_id' => $item->producto_id,
                    'tienda_id' => $item->producto->tienda_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->subtotal,
                ]);
            }

            pagoordene::create([
                'orden_id' => $orden->id,
                'monto' => $total,
                'metodo_pago' => 'PayPal',
                'estado' => 'COMPLETED',
                'fecha_pago' => now(),
            ]);

            carrito::where('cliente_id', $cliente->id)->delete();

            return $orden;
        });

        try {
            Mail::raw(
                "Hola {$usuario->nombre}, tu compra fue confirmada correctamente.\n\nNúmero de orden: {$orden->numero_orden}\nTotal pagado: $ {$orden->total} MXN\nEstado: {$orden->estado}\n\nPuedes revisar tus compras y pagos desde tu panel de cliente.\n\nGracias por comprar en Virtuality Mall.",
                function ($message) use ($usuario) {
                    $message->to($usuario->email)
                        ->subject('Confirmación de compra - Virtuality Mall');
                }
            );
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de compra: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Compra finalizada correctamente',
            'orden' => $orden
        ], 201);
    }
}