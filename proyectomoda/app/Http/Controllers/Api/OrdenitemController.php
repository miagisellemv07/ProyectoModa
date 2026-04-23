<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ordenitem;

class OrdenitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ordenitem::all();

        return response([
            'success' => true,
            'message' => $items->isEmpty() ? 'No orden items found' : 'Orden items retrieved successfully',
            'items' => $items
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating ordenitem (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'orden_id' => 'required|exists:ordenes,id',
            'producto_id' => 'required|exists:productos,id',
            'tienda_id' => 'required|exists:tiendas,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);

        $item = ordenitem::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Orden item created successfully',
            'item' => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = ordenitem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'msg' => 'Orden item not found'
            ], 404);
        }

        return response([
            'success' => true,
            'item' => $item
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = ordenitem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'msg' => 'Orden item not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing ordenitem (API usually does not need this)',
            'item' => $item
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = ordenitem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'msg' => 'Orden item not found'
            ], 404);
        }

        $validateData = $request->validate([
            'orden_id' => 'sometimes|required|exists:ordenes,id',
            'producto_id' => 'sometimes|required|exists:productos,id',
            'tienda_id' => 'sometimes|required|exists:tiendas,id',
            'cantidad' => 'sometimes|required|integer|min:1',
            'precio_unitario' => 'sometimes|required|numeric',
            'subtotal' => 'sometimes|required|numeric',
        ]);

        $item->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Orden item updated successfully',
            'item' => $item
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ordenitem::find($id);

        if (!$item) {
            return response([
                'success' => false,
                'msg' => 'Orden item not found'
            ], 404);
        }

        $item->delete();

        return response([
            'success' => true,
            'msg' => 'Orden item deleted successfully'
        ], 200);
    }
}