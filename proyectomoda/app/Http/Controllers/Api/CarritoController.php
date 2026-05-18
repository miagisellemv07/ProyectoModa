<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\carrito;
use App\Models\cliente;
use App\Models\producto;
use Tymon\JWTAuth\Facades\JWTAuth;

class CarritoController extends Controller
{
    private function clienteAutenticado()
    {
        $usuario = JWTAuth::parseToken()->authenticate();

        return cliente::firstOrCreate(
            ['usuario_id' => $usuario->id],
            ['direccion' => 'Sin dirección']
        );
    }

    public function index()
    {
        $cliente = $this->clienteAutenticado();

        $carrito = carrito::with(['producto.tienda'])
            ->where('cliente_id', $cliente->id)
            ->get();

        return response()->json([
            "data" => $carrito,
            "status" => "success"
        ], 200);
    }

    public function store(Request $request)
    {
        $cliente = $this->clienteAutenticado();

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = producto::findOrFail($request->producto_id);

        $item = carrito::where('cliente_id', $cliente->id)
            ->where('producto_id', $producto->id)
            ->first();

        if ($item) {
            $item->cantidad += $request->cantidad;
            $item->subtotal = $item->cantidad * $item->precio_unitario;
            $item->save();
        } else {
            $item = carrito::create([
                'cliente_id' => $cliente->id,
                'producto_id' => $producto->id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $producto->precio * $request->cantidad
            ]);
        }

        return response()->json([
            "data" => $item,
            "status" => "success",
            "message" => "Producto agregado al carrito"
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $cliente = $this->clienteAutenticado();

        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $item = carrito::where('cliente_id', $cliente->id)
            ->findOrFail($id);

        $item->cantidad = $request->cantidad;
        $item->subtotal = $item->cantidad * $item->precio_unitario;
        $item->save();

        return response()->json([
            "data" => $item,
            "status" => "success"
        ], 200);
    }

    public function destroy(string $id)
    {
        $cliente = $this->clienteAutenticado();

        $item = carrito::where('cliente_id', $cliente->id)
            ->findOrFail($id);

        $item->delete();

        return response()->json([
            "message" => "Producto eliminado del carrito"
        ], 200);
    }
}