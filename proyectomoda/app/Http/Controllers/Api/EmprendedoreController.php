<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\emprendedore;

class EmprendedoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emprendedores = emprendedore::with('usuario_id')->get();

        return response([
            'success' => true,
            'message' => $emprendedores->isEmpty() ? 'No emprendedores found' : 'Emprendedores retrieved successfully',
            'emprendedores' => $emprendedores
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating emprendedore (API usually does not need this)'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'nombre_marca' => 'required|string|max:255',
        ]);

        $emprendedore = emprendedore::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Emprendedore created successfully',
            'emprendedore' => $emprendedore
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $emprendedore = emprendedore::with('usuario_id')->find($id);

        if (!$emprendedore) {
            return response([
                'success' => false,
                'msg' => 'Emprendedore not found'
            ], 404);
        }

        return response([
            'success' => true,
            'emprendedore' => $emprendedore
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $emprendedore = emprendedore::find($id);

        if (!$emprendedore) {
            return response([
                'success' => false,
                'msg' => 'Emprendedore not found'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing emprendedore (API usually does not need this)',
            'emprendedore' => $emprendedore
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $emprendedore = emprendedore::find($id);

        if (!$emprendedore) {
            return response([
                'success' => false,
                'msg' => 'Emprendedore not found'
            ], 404);
        }

        $validateData = $request->validate([
            'usuario_id' => 'sometimes|required|exists:users,id',
            'nombre_marca' => 'sometimes|required|string|max:255',
        ]);

        $emprendedore->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Emprendedore updated successfully',
            'emprendedore' => $emprendedore
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $emprendedore = emprendedore::find($id);

        if (!$emprendedore) {
            return response([
                'success' => false,
                'msg' => 'Emprendedore not found'
            ], 404);
        }

        $emprendedore->delete();

        return response([
            'success' => true,
            'msg' => 'Emprendedore deleted successfully'
        ], 200);
    }
}