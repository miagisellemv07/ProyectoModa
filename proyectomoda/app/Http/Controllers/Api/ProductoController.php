<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $producto = producto::with(['tienda'])->get();

        return response()->json([
            "data" => $producto,
            "status" => "success"
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|min:3|max:50',
            'descripcion' => 'required|min:5',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'tienda_id' => 'required|exists:tiendas,id'
        ]);

        $producto = new producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->tienda_id = $request->tienda_id;

        $producto->save();

        return response()->json([
            "data" => $producto,
            "status" => "success"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = producto::with(['tienda'])->find($id);

        if ($producto == null) {
            return response()->json([
                "message" => "producto no encontrado",
                "status" => "Error"
            ], 404);
        }

        return response()->json([
            "data" => $producto,
            "status" => "Success"
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|min:3|max:50',
            'descripcion' => 'required|min:5',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'tienda_id' => 'required|exists:tiendas,id'
        ]);

        $producto = producto::find($id);

        if ($producto == null) {
            return response()->json([
                "message" => "producto no encontrado",
                "status" => "Error"
            ], 404);
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->tienda_id = $request->tienda_id;

        $producto->save();

        return response()->json([
            "data" => $producto,
            "status" => "success"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = producto::find($id);

        if ($producto == null) {
            return response()->json([
                "error" => "NO ENCONTRADO",
                "status" => "ERROR"
            ], 404);
        }

        $producto->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Registro eliminado correctamente"
        ], 200);
    }
}