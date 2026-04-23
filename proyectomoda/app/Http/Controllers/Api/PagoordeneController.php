<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pagoordene;

class PagoordeneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = pagoordene::all();

        return response([
            'success' => true,
            'message' => $pagos->isEmpty() ? 'No pagos found' : 'Pagos retrieved successfully',
            'pagos' => $pagos
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating pagoordene (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'orden_id' => 'required|exists:ordenes,id',
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'fecha_pago' => 'required|date',
        ]);

        $pago = pagoordene::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Pago created successfully',
            'pago' => $pago
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pago = pagoordene::find($id);

        if (!$pago) {
            return response([
                'success' => false,
                'msg' => 'Pago not found'
            ], 404);
        }

        return response([
            'success' => true,
            'pago' => $pago
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pago = pagoordene::find($id);

        if (!$pago) {
            return response([
                'success' => false,
                'msg' => 'Pago not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing pagoordene (API usually does not need this)',
            'pago' => $pago
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pago = pagoordene::find($id);

        if (!$pago) {
            return response([
                'success' => false,
                'msg' => 'Pago not found'
            ], 404);
        }

        $validateData = $request->validate([
            'orden_id' => 'sometimes|required|exists:ordenes,id',
            'monto' => 'sometimes|required|numeric',
            'metodo_pago' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|max:255',
            'fecha_pago' => 'sometimes|required|date',
        ]);

        $pago->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Pago updated successfully',
            'pago' => $pago
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pago = pagoordene::find($id);

        if (!$pago) {
            return response([
                'success' => false,
                'msg' => 'Pago not found'
            ], 404);
        }

        $pago->delete();

        return response([
            'success' => true,
            'msg' => 'Pago deleted successfully'
        ], 200);
    }
}