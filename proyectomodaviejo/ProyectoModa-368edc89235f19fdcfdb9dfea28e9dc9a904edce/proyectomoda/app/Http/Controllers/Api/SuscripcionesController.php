<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\suscripcione;

class SuscripcionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suscripcione=suscripcione::with(['tienda'])->get();
        return response()->json([
            "data"=>$suscripcione,
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
        'tienda_id' => 'required|exists:tiendas,id',
        'precio_mensual' => 'required|numeric',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'nullable|date',
        'estado' => 'required|string'
    ]);

    $suscripcione = new suscripcione();
    $suscripcione->tienda_id = $request->tienda_id;
    $suscripcione->precio_mensual = $request->precio_mensual;
    $suscripcione->fecha_inicio = $request->fecha_inicio;
    $suscripcione->fecha_fin = $request->fecha_fin;
    $suscripcione->estado = $request->estado;

    $suscripcione->save();

    return response()->json([
        "data" => $suscripcione,
        "status" => "success"
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $suscripcione=suscripcione::find($id);
        if($suscripcione == null){
            return response()->json([
                "message"=>"suscripcion no encontrada",
                "status"=>"Error"
            ],404);
        }
        return response()->json([
            "data"=>$suscripcione,
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
        'tienda_id' => 'required|exists:tiendas,id',
        'precio_mensual' => 'required|numeric',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'nullable|date',
        'estado' => 'required|string'
    ]);

  $suscripcione = suscripcione::find($id);
    $suscripcione->tienda_id = $request->tienda_id;
    $suscripcione->precio_mensual = $request->precio_mensual;
    $suscripcione->fecha_inicio = $request->fecha_inicio;
    $suscripcione->fecha_fin = $request->fecha_fin;
    $suscripcione->estado = $request->estado;

    $suscripcione->save();

    return response()->json([
        "data" => $suscripcione,
        "status" => "success"
    ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $suscripcione = suscripcione::find($id);
        if($suscripcione == null){
            return response()->json([
                "error"=>"NO ENCONTRADO",
                "status"=>"ERROR"
            ],404);
        }
        $suscripcione->delete();
        return response()->json([
            "status"=>"Success",
            "message"=>"Registro eliminado correctamente"
        ],204);
    }
}
