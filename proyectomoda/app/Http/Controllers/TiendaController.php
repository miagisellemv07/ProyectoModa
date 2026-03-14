<?php

namespace App\Http\Controllers;

use App\Models\tienda;
use App\Models\emprendedore;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TiendaController extends Controller
{
    public function index()
    {
        $tiendas = tienda::with('emprendedor.usuario')
            ->orderBy('id', 'desc')
            ->get();

        return view('tiendas.index', compact('tiendas'));
    }

    public function create()
    {
        $emprendedores = emprendedore::with('usuario')->get();
        return view('tiendas.create', compact('emprendedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'logo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'categoria' => ['required', 'string', 'max:100'],
            'emprendedor_id' => ['required', Rule::exists('emprendedores', 'id')],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'logo.required' => 'El logo es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'categoria.required' => 'La categoría es obligatoria.',
            'emprendedor_id.required' => 'Debes seleccionar un emprendedor.',
        ]);

        tienda::create([
            'nombre' => $request->nombre,
            'logo' => $request->logo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'emprendedor_id' => $request->emprendedor_id,
        ]);

        return redirect()->route('tiendas.index')
            ->with('success', 'Tienda creada correctamente.');
    }

    public function show(string $id)
    {
        $tienda = tienda::with('emprendedor.usuario')->findOrFail($id);
        return view('tiendas.show', compact('tienda'));
    }

    public function edit(string $id)
    {
        $tienda = tienda::findOrFail($id);
        $emprendedores = emprendedore::with('usuario')->get();

        return view('tiendas.edit', compact('tienda', 'emprendedores'));
    }

    public function update(Request $request, string $id)
    {
        $tienda = tienda::findOrFail($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'logo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'categoria' => ['required', 'string', 'max:100'],
            'emprendedor_id' => ['required', Rule::exists('emprendedores', 'id')],
        ]);

        $tienda->update([
            'nombre' => $request->nombre,
            'logo' => $request->logo,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'emprendedor_id' => $request->emprendedor_id,
        ]);

        return redirect()->route('tiendas.index')
            ->with('success', 'Tienda actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $tienda = tienda::findOrFail($id);
        $tienda->delete();

        return redirect()->route('tiendas.index')
            ->with('success', 'Tienda eliminada correctamente.');
    }
}