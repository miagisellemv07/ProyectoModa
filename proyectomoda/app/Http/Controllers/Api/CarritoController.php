<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\carrito;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = carrito::with(['cliente', 'producto'])->get();

        return response()->json([
            "data" => $carrito,
            "status" => "success"
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ]);

        $carrito = new carrito();
        $carrito->cliente_id = $request->cliente_id;
        $carrito->producto_id = $request->producto_id;
        $carrito->cantidad = $request->cantidad;
        $carrito->precio_unitario = $request->precio_unitario;
        $carrito->subtotal = $request->subtotal;

        $carrito->save();

        return response()->json([
            "data" => $carrito,
            "status" => "success"
        ], 201);
    }

    public function show(string $id)
    {
        $carrito = carrito::with(['cliente', 'producto'])->find($id);

        return response()->json([
            "data" => $carrito,
            "status" => "success"
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ]);

        $carrito = carrito::find($id);
        $carrito->cliente_id = $request->cliente_id;
        $carrito->producto_id = $request->producto_id;
        $carrito->cantidad = $request->cantidad;
        $carrito->precio_unitario = $request->precio_unitario;
        $carrito->subtotal = $request->subtotal;

        $carrito->save();

        return response()->json([
            "data" => $carrito,
            "status" => "success"
        ], 200);
    }

    public function destroy(string $id)
    {
        $carrito = carrito::find($id);
        $carrito->delete();

        return response()->json([
            "message" => "Eliminado correctamente"
        ], 200);
    }
}