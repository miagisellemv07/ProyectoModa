<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('id', 'desc')->get();
        return view('users.index', compact('usuarios'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'tel' => ['nullable', 'string', 'max:20'],
            'rol' => ['required', Rule::in(['admin', 'emprendedor', 'cliente'])],
            'password' => ['required', 'string', 'confirmed'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debes escribir un correo válido.',
            'email.unique' => 'Ese correo ya está registrado.',
            'rol.required' => 'Debes seleccionar un rol.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'tel' => $request->tel,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('users.show', compact('usuario'));
    }

    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('users.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($usuario->id)
            ],
            'tel' => ['nullable', 'string', 'max:20'],
            'rol' => ['required', Rule::in(['admin', 'emprendedor', 'cliente'])],
            'password' => ['nullable', 'string', 'confirmed'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Debes escribir un correo válido.',
            'email.unique' => 'Ese correo ya está registrado.',
            'rol.required' => 'Debes seleccionar un rol.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->tel = $request->tel;
        $usuario->rol = $request->rol;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);

        DB::transaction(function () use ($usuario) {

            /*
            |--------------------------------------------------------------------------
            | 1) Lado CLIENTE
            |--------------------------------------------------------------------------
            */
            $clienteIds = DB::table('clientes')
                ->where('usuario_id', $usuario->id)
                ->pluck('id')
                ->all();

            if (!empty($clienteIds)) {
                DB::table('carritos')
                    ->whereIn('cliente_id', $clienteIds)
                    ->delete();

                $ordenIds = DB::table('ordenes')
                    ->whereIn('cliente_id', $clienteIds)
                    ->pluck('id')
                    ->all();

                if (!empty($ordenIds)) {
                    DB::table('ordenitems')
                        ->whereIn('orden_id', $ordenIds)
                        ->delete();

                    DB::table('pagoordenes')
                        ->whereIn('orden_id', $ordenIds)
                        ->delete();

                    DB::table('ordenes')
                        ->whereIn('id', $ordenIds)
                        ->delete();
                }

                DB::table('clientes')
                    ->whereIn('id', $clienteIds)
                    ->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | 2) Lado EMPRENDEDOR
            |--------------------------------------------------------------------------
            */
            $emprendedorIds = DB::table('emprendedores')
                ->where('usuario_id', $usuario->id)
                ->pluck('id')
                ->all();

            if (!empty($emprendedorIds)) {
                $tiendaIds = DB::table('tiendas')
                    ->whereIn('emprendedor_id', $emprendedorIds)
                    ->pluck('id')
                    ->all();

                if (!empty($tiendaIds)) {
                    $suscripcionIds = DB::table('suscripciones')
                        ->whereIn('tienda_id', $tiendaIds)
                        ->pluck('id')
                        ->all();

                    if (!empty($suscripcionIds)) {
                        DB::table('pagosuscripciones')
                            ->whereIn('suscripcion_id', $suscripcionIds)
                            ->delete();

                        DB::table('suscripciones')
                            ->whereIn('id', $suscripcionIds)
                            ->delete();
                    }

                    $productoIds = DB::table('productos')
                        ->whereIn('tienda_id', $tiendaIds)
                        ->pluck('id')
                        ->all();

                    if (!empty($productoIds)) {
                        DB::table('carritos')
                            ->whereIn('producto_id', $productoIds)
                            ->delete();

                        DB::table('ordenitems')
                            ->whereIn('producto_id', $productoIds)
                            ->delete();

                        DB::table('productos')
                            ->whereIn('id', $productoIds)
                            ->delete();
                    }

                    DB::table('ordenitems')
                        ->whereIn('tienda_id', $tiendaIds)
                        ->delete();

                    DB::table('tiendas')
                        ->whereIn('id', $tiendaIds)
                        ->delete();
                }

                DB::table('emprendedores')
                    ->whereIn('id', $emprendedorIds)
                    ->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | 3) Sesiones del usuario
            |--------------------------------------------------------------------------
            */
            DB::table('sessions')
                ->where('user_id', $usuario->id)
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | 4) Finalmente el usuario
            |--------------------------------------------------------------------------
            */
            DB::table('users')
                ->where('id', $usuario->id)
                ->delete();
        });

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}