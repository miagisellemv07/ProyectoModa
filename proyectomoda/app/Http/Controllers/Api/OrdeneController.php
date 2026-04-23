<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ordene;

class OrdeneController extends Controller
{
    public function index()
    {
        $ordenes = ordene::with('cliente_id')->get();

        return response([
            'success' => true,
            'message' => $ordenes->isEmpty() ? 'No ordenes found' : 'Ordenes retrieved successfully',
            'ordenes' => $ordenes
        ], 200);
    }

    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating orden (API usually does not need this)'
        ], 200);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero_orden' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'total' => 'required|numeric',
            'direccion_envio' => 'required|string',
            'telefono' => 'required|string|max:20',
            'notas' => 'nullable|string',
        ]);

        $orden = ordene::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Orden created successfully',
            'orden' => $orden
        ], 201);
    }

    public function show(string $id)
    {
        $orden = ordene::with('cliente_id')->find($id);

        if (!$orden) {
            return response([
                'success' => false,
                'msg' => 'Orden not found'
            ], 404);
        }

        return response([
            'success' => true,
            'orden' => $orden
        ], 200);
    }

    public function edit(string $id)
    {
        $orden = ordene::find($id);

        if (!$orden) {
            return response([
                'success' => false,
                'msg' => 'Orden not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing orden (API usually does not need this)',
            'orden' => $orden
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $orden = ordene::find($id);

        if (!$orden) {
            return response([
                'success' => false,
                'msg' => 'Orden not found'
            ], 404);
        }

        $validateData = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'numero_orden' => 'sometimes|required|string|max:255',
            'estado' => 'sometimes|required|string|max:255',
            'total' => 'sometimes|required|numeric',
            'direccion_envio' => 'sometimes|required|string',
            'telefono' => 'sometimes|required|string|max:20',
            'notas' => 'nullable|string',
        ]);

        $orden->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Orden updated successfully',
            'orden' => $orden
        ], 200);
    }

    public function destroy(string $id)
    {
        $orden = ordene::find($id);

        if (!$orden) {
            return response([
                'success' => false,
                'msg' => 'Orden not found'
            ], 404);
        }

        $orden->delete();

        return response([
            'success' => true,
            'msg' => 'Orden deleted successfully'
        ], 200);
    }
}