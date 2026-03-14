<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\emprendedore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmprendedorController extends Controller
{
    public function index()
    {
        $emprendedores = User::with('emprendedor')
            ->where('rol', 'emprendedor')
            ->orderBy('id', 'desc')
            ->get();

        return view('emprendedores.index', compact('emprendedores'));
    }

    public function create()
    {
        return view('emprendedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'tel' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed'],
            'nombre_marca' => ['required', 'string', 'max:150'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debes escribir un correo válido.',
            'email.unique' => 'Ese correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'nombre_marca.required' => 'El nombre de la marca es obligatorio.',
        ]);

        $usuario = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'tel' => $request->tel,
            'rol' => 'emprendedor',
            'password' => Hash::make($request->password),
        ]);

        emprendedore::create([
            'usuario_id' => $usuario->id,
            'nombre_marca' => $request->nombre_marca,
        ]);

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor creado correctamente.');
    }

    public function show(string $id)
    {
        $emprendedor = User::where('rol', 'emprendedor')->findOrFail($id);
        $detalle = emprendedore::where('usuario_id', $emprendedor->id)->first();

        return view('emprendedores.show', compact('emprendedor', 'detalle'));
    }

    public function edit(string $id)
    {
        $emprendedor = User::where('rol', 'emprendedor')->findOrFail($id);
        $detalle = emprendedore::where('usuario_id', $emprendedor->id)->first();

        return view('emprendedores.edit', compact('emprendedor', 'detalle'));
    }

    public function update(Request $request, string $id)
    {
        $emprendedor = User::where('rol', 'emprendedor')->findOrFail($id);
        $detalle = emprendedore::where('usuario_id', $emprendedor->id)->first();

        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($emprendedor->id)
            ],
            'tel' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'confirmed'],
            'nombre_marca' => ['required', 'string', 'max:150'],
        ]);

        $emprendedor->nombre = $request->nombre;
        $emprendedor->apellido = $request->apellido;
        $emprendedor->email = $request->email;
        $emprendedor->tel = $request->tel;
        $emprendedor->rol = 'emprendedor';

        if ($request->filled('password')) {
            $emprendedor->password = Hash::make($request->password);
        }

        $emprendedor->save();

        if ($detalle) {
            $detalle->nombre_marca = $request->nombre_marca;
            $detalle->save();
        }

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $emprendedor = User::where('rol', 'emprendedor')->findOrFail($id);

        emprendedore::where('usuario_id', $emprendedor->id)->delete();
        $emprendedor->delete();

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor eliminado correctamente.');
    }
}