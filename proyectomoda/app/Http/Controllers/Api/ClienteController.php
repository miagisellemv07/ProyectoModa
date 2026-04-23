<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = cliente::with('usuario_id')->get();

        return response([
            'success' => true,
            'message' => $clientes->isEmpty() ? 'No clientes found' : 'Clientes retrieved successfully',
            'clientes' => $clientes
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating cliente (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'direccion' => 'required|string',
        ]);

        $cliente = cliente::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Cliente created successfully',
            'cliente' => $cliente
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = cliente::with('usuario_id')->find($id);

        if (!$cliente) {
            return response([
                'success' => false,
                'msg' => 'Cliente not found'
            ], 404);
        }

        return response([
            'success' => true,
            'cliente' => $cliente
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = cliente::find($id);

        if (!$cliente) {
            return response([
                'success' => false,
                'msg' => 'Cliente not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing cliente (API usually does not need this)',
            'cliente' => $cliente
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cliente = cliente::find($id);

        if (!$cliente) {
            return response([
                'success' => false,
                'msg' => 'Cliente not found'
            ], 404);
        }

        $validateData = $request->validate([
            'usuario_id' => 'sometimes|required|exists:users,id',
            'direccion' => 'sometimes|required|string',
        ]);

        $cliente->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Cliente updated successfully',
            'cliente' => $cliente
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = cliente::find($id);

        if (!$cliente) {
            return response([
                'success' => false,
                'msg' => 'Cliente not found'
            ], 404);
        }

        $cliente->delete();

        return response([
            'success' => true,
            'msg' => 'Cliente deleted successfully'
        ], 200);
    }
}