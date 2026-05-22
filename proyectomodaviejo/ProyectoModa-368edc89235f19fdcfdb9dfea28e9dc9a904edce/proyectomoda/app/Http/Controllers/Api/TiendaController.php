<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tienda;

class TiendaController extends Controller
{
    public function index()
    {
        $tiendas = tienda::with(['emprendedor.usuario'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "data" => $tiendas,
            "status" => "success"
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'emprendedor_id' => 'required|exists:emprendedores,id',
            'nombre' => 'required|min:3|max:150',
            'logo' => 'required|string|max:255',
            'descripcion' => 'required|min:5',
            'categoria' => 'required|max:100'
        ]);

        $tienda = tienda::create([
            'emprendedor_id' => $request->emprendedor_id,
            'nombre' => $request->nombre,
            'logo' => $request->logo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
        ]);

        return response()->json([
            "data" => $tienda,
            "status" => "success"
        ], 201);
    }

    public function show(string $id)
    {
        $tienda = tienda::with(['emprendedor.usuario'])->find($id);

        if ($tienda == null) {
            return response()->json([
                "message" => "tienda no encontrada",
                "status" => "Error"
            ], 404);
        }

        return response()->json([
            "data" => $tienda,
            "status" => "Success"
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $tienda = tienda::find($id);

        if ($tienda == null) {
            return response()->json([
                "message" => "tienda no encontrada",
                "status" => "Error"
            ], 404);
        }

        $validated = $request->validate([
            'emprendedor_id' => 'required|exists:emprendedores,id',
            'nombre' => 'required|min:3|max:150',
            'logo' => 'required|string|max:255',
            'descripcion' => 'required|min:5',
            'categoria' => 'required|max:100'
        ]);

        $tienda->update([
            'emprendedor_id' => $request->emprendedor_id,
            'nombre' => $request->nombre,
            'logo' => $request->logo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
        ]);

        return response()->json([
            "data" => $tienda,
            "status" => "success"
        ], 200);
    }

    public function destroy(string $id)
    {
        $tienda = tienda::find($id);

        if ($tienda == null) {
            return response()->json([
                "error" => "NO ENCONTRADO",
                "status" => "ERROR"
            ], 404);
        }

        $tienda->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Registro eliminado correctamente"
        ], 200);
    }
}