<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pagosuscripcione;

class PagosuscripcioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = pagosuscripcione::with(['suscripcion_id'])->get();

        return response()->json([
            "data" => $pagos,
            "status" => "success"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'suscripcion_id' => 'required|exists:suscripciones,id',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date'
        ]);

        $pagosuscripcione = new pagosuscripcione();
        $papagosuscripcionego->suscripcion_id = $request->suscripcion_id;
        $papagosuscripcionego->monto = $request->monto;
        $papagosuscripcionego->metodo_pago = $request->metodo_pago;
        $papagosuscripcionego->fecha_pago = $request->fecha_pago;

        $papagosuscripcionego->save();

        return response()->json([
            "data" => $pagosuscripcione,
            "status" => "success"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pago = pagosuscripcione::with(['suscripcion_id'])->find($id);

        if ($pago == null) {
            return response()->json([
                "message" => "pago no encontrado",
                "status" => "Error"
            ], 404);
        }

        return response()->json([
            "data" => $pago,
            "status" => "Success"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'suscripcion_id' => 'required|exists:suscripciones,id',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|string',
            'fecha_pago' => 'required|date'
        ]);

        $pago = pagosuscripcione::find($id);

        if ($pago == null) {
            return response()->json([
                "message" => "pago no encontrado",
                "status" => "Error"
            ], 404);
        }

        $pago->suscripcion_id = $request->suscripcion_id;
        $pago->monto = $request->monto;
        $pago->metodo_pago = $request->metodo_pago;
        $pago->fecha_pago = $request->fecha_pago;

        $pago->save();

        return response()->json([
            "data" => $pago,
            "status" => "success"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pago = pagosuscripcione::find($id);

        if ($pago == null) {
            return response()->json([
                "error" => "NO ENCONTRADO",
                "status" => "ERROR"
            ], 404);
        }

        $pago->delete();

        return response()->json([
            "status" => "Success",
            "message" => "Registro eliminado correctamente"
        ], 200);
    }
}