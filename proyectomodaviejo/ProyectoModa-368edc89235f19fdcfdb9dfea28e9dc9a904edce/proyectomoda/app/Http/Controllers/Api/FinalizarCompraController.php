<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\carrito;
use App\Models\cliente;
use App\Models\ordene;
use App\Models\ordenitem;
use App\Models\pagoordene;
use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

        foreach ($carrito as $item) {
            if (!$item->producto) {
                return response()->json([
                    'message' => 'Uno de los productos del carrito ya no existe'
                ], 422);
            }

            if ($item->cantidad > $item->producto->stock) {
                return response()->json([
                    'message' => 'No hay suficiente stock para el producto: ' . $item->producto->nombre
                ], 422);
            }
        }

        $subtotalCarrito = $carrito->sum(function ($item) {
            return $item->cantidad * $item->precio_unitario;
        });

        $impuestos = $subtotalCarrito * 0.16;
        $totalCalculado = round($subtotalCarrito + $impuestos, 2);
        $totalRecibido = round((float) $request->total, 2);

        if (abs($totalCalculado - $totalRecibido) > 0.05) {
            return response()->json([
                'message' => 'El total de la compra no coincide con el carrito actual',
                'total_calculado' => $totalCalculado,
                'total_recibido' => $totalRecibido,
            ], 422);
        }

        $orden = DB::transaction(function () use ($request, $cliente, $usuario, $carrito, $totalCalculado) {
            $orden = ordene::create([
                'cliente_id' => $cliente->id,
                'numero_orden' => 'ORD-' . time(),
                'estado' => 'pagada',
                'total' => $totalCalculado,
                'direccion_envio' => $cliente->direccion ?? 'Sin dirección',
                'telefono' => $usuario->tel ?? 'Sin teléfono',
                'notas' => 'Pago PayPal: ' . $request->paypal_order_id,
            ]);

            foreach ($carrito as $item) {
                $producto = producto::where('id', $item->producto_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($item->cantidad > $producto->stock) {
                    throw new \Exception('No hay suficiente stock para el producto: ' . $producto->nombre);
                }

                ordenitem::create([
                    'orden_id' => $orden->id,
                    'producto_id' => $item->producto_id,
                    'tienda_id' => $producto->tienda_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->subtotal,
                ]);

                $producto->stock = $producto->stock - $item->cantidad;
                $producto->save();
            }

            pagoordene::create([
                'orden_id' => $orden->id,
                'monto' => $totalCalculado,
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
            // Si falla el correo, no se rompe la compra.
        }

        return response()->json([
            'message' => 'Compra finalizada correctamente',
            'orden' => $orden
        ], 201);
    }
}