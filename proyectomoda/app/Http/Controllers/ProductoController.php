<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\tienda;
use App\Models\emprendedore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    private function obtenerEmprendedorAutenticado()
    {
        $usuario = Auth::user();

        if (!$usuario || $usuario->rol !== 'emprendedor') {
            abort(403, 'No autorizado.');
        }

        $emprendedor = emprendedore::where('usuario_id', $usuario->id)->first();

        if (!$emprendedor) {
            abort(404, 'No se encontró el registro del emprendedor.');
        }

        return $emprendedor;
    }

    private function productoDelEmprendedor($id)
    {
        $emprendedor = $this->obtenerEmprendedorAutenticado();

        return producto::whereHas('tienda', function ($query) use ($emprendedor) {
            $query->where('emprendedor_id', $emprendedor->id);
        })->findOrFail($id);
    }

    public function index()
    {
        $emprendedor = $this->obtenerEmprendedorAutenticado();

        $productos = producto::with('tienda')
            ->whereHas('tienda', function ($query) use ($emprendedor) {
                $query->where('emprendedor_id', $emprendedor->id);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $emprendedor = $this->obtenerEmprendedorAutenticado();

        $tiendas = tienda::where('emprendedor_id', $emprendedor->id)->get();

        return view('productos.create', compact('tiendas'));
    }

    public function store(Request $request)
    {
        $emprendedor = $this->obtenerEmprendedorAutenticado();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tienda_id' => 'required|exists:tiendas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser numérico.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'tienda_id.required' => 'La tienda es obligatoria.',
            'tienda_id.exists' => 'La tienda seleccionada no existe.',
        ]);

        $tienda = tienda::where('id', $request->tienda_id)
            ->where('emprendedor_id', $emprendedor->id)
            ->firstOrFail();

        producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'tienda_id' => $tienda->id,
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
        $emprendedor = $this->obtenerEmprendedorAutenticado();
        $producto = $this->productoDelEmprendedor($id);
        $tiendas = tienda::where('emprendedor_id', $emprendedor->id)->get();

        return view('productos.edit', compact('producto', 'tiendas'));
    }

    public function update(Request $request, string $id)
    {
        $emprendedor = $this->obtenerEmprendedorAutenticado();
        $producto = $this->productoDelEmprendedor($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'tienda_id' => 'required|exists:tiendas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser numérico.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'tienda_id.required' => 'La tienda es obligatoria.',
            'tienda_id.exists' => 'La tienda seleccionada no existe.',
        ]);

        $tienda = tienda::where('id', $request->tienda_id)
            ->where('emprendedor_id', $emprendedor->id)
            ->firstOrFail();

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'tienda_id' => $tienda->id,
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
}