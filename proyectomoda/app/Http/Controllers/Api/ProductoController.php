<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = producto::with(['tienda.emprendedor.usuario'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "data" => $productos,
            "status" => "success"
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3|max:255',
            'descripcion' => 'required|min:5',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tienda_id' => 'required|exists:tiendas,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp,jfif|max:4096'
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'tienda_id' => $request->tienda_id,
        ];

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = producto::create($datos);

        return response()->json([
            "data" => $producto,
            "status" => "success"
        ], 201);
    }

    public function show(string $id)
    {
        $producto = producto::with(['tienda.emprendedor.usuario'])->find($id);

        if (!$producto) {
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

    public function update(Request $request, string $id)
    {
        $producto = producto::find($id);

        if (!$producto) {
            return response()->json([
                "message" => "producto no encontrado",
                "status" => "Error"
            ], 404);
        }

        $request->validate([
            'nombre' => 'required|min:3|max:255',
            'descripcion' => 'required|min:5',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tienda_id' => 'required|exists:tiendas,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp,jfif|max:4096'
        ]);

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->tienda_id = $request->tienda_id;

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return response()->json([
            "data" => $producto,
            "status" => "success"
        ], 200);
    }

    public function destroy(string $id)
    {
        $producto = producto::find($id);

        if (!$producto) {
            return response()->json([
                "error" => "NO ENCONTRADO",
                "status" => "ERROR"
            ], 404);
        }

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Registro eliminado correctamente"
        ], 200);
    }
}