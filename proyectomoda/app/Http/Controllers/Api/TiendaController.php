<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tienda;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $tienda=tienda::with(['emprendedor'])->get();
        return response()->json([
            "data"=>$tienda,
            "status"=>"success"
        ],200);
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
        'emprendedor_id' => 'required|exists:emprendedores,id',
        'nombre' => 'required|min:3|max:50',
        'logo' => 'nullable|string',
        'descripcion' => 'required|min:5',
        'categoria' => 'required'
    ]);

    $tienda = new tienda();
    $tienda->emprendedor_id = $request->emprendedor_id;
    $tienda->nombre = $request->nombre;
    $tienda->logo = $request->logo;
    $tienda->descripcion = $request->descripcion;
    $tienda->categoria = $request->categoria;

    $tienda->save();

    return response()->json([
        "data" => $tienda,
        "status" => "success"
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tienda=tienda::find($id);
        if($tienda == null){
            return response()->json([
                "message"=>"tienda no encontrada",
                "status"=>"Error"
            ],404);
        }
        return response()->json([
            "data"=>$tienda,
            "status"=>"Success"
        ],200);
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
        'emprendedor_id' => 'required|exists:emprendedores,id',
        'nombre' => 'required|min:3|max:50',
        'logo' => 'nullable|string',
        'descripcion' => 'required|min:5',
        'categoria' => 'required'
    ]);

   $tienda = tienda::find($id);
    $tienda->emprendedor_id = $request->emprendedor_id;
    $tienda->nombre = $request->nombre;
    $tienda->logo = $request->logo;
    $tienda->descripcion = $request->descripcion;
    $tienda->categoria = $request->categoria;

    $tienda->save();

    return response()->json([
        "data" => $tienda,
        "status" => "success"
    ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
           $tienda = tienda::find($id);
        if($tienda == null){
            return response()->json([
                "error"=>"NO ENCONTRADO",
                "status"=>"ERROR"
            ],404);
        }
        $tienda->delete();
        return response()->json([
            "status"=>"Success",
            "message"=>"Registro eliminado correctamente"
        ],204);
    }
}
