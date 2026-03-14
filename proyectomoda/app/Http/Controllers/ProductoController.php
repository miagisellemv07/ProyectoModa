<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\tienda;
use App\Models\emprendedore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->firstOrFail();

        $tiendaIds = tienda::where('emprendedor_id', $emprendedor->id)->pluck('id');

        $productos = producto::with('tienda')
            ->whereIn('tienda_id', $tiendaIds)
            ->orderBy('id', 'desc')
            ->get();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $usuario = Auth::user();
        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->firstOrFail();

        $tiendas = tienda::where('emprendedor_id', $emprendedor->id)->get();

        return view('productos.create', compact('tiendas'));
    }

    public function store(Request $request)
    {
        $usuario = Auth::user();
        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->firstOrFail();
        $tiendasPermitidas = tienda::where('emprendedor_id', $emprendedor->id)->pluck('id')->toArray();

        $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'tienda_id' => ['required', Rule::in($tiendasPermitidas)],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'stock.required' => 'El stock es obligatorio.',
            'tienda_id.required' => 'Debes seleccionar una tienda.',
        ]);

        producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'tienda_id' => $request->tienda_id,
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(string $id)
    {
        $producto = $this->productoDelEmprendedor($id);
        return view('productos.show', compact('producto'));
    }

    public function edit(string $id)
    {
        $usuario = Auth::user();
        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->firstOrFail();
        $producto = $this->productoDelEmprendedor($id);
        $tiendas = tienda::where('emprendedor_id', $emprendedor->id)->get();

        return view('productos.edit', compact('producto', 'tiendas'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = Auth::user();
        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->firstOrFail();
        $tiendasPermitidas = tienda::where('emprendedor_id', $emprendedor->id)->pluck('id')->toArray();

        $producto = $this->productoDelEmprendedor($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'tienda_id' => ['required', Rule::in($tiendasPermitidas)],
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'tienda_id' => $request->tienda_id,
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $producto = $this->productoDelEmprendedor($id);
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function productoDelEmprendedor($id)
    {
        $usuario = Auth::user();
        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->firstOrFail();
        $tiendaIds = tienda::where('emprendedor_id', $emprendedor->id)->pluck('id');

        return producto::with('tienda')
            ->where('id', $id)
            ->whereIn('tienda_id', $tiendaIds)
            ->firstOrFail();
    }
}