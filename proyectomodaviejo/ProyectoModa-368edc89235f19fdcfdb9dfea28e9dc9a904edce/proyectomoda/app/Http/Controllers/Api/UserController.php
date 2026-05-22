<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json([
            "data" => $usuarios,
            "status" => "success"
        ], 200);
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
        ]);

        $usuario = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'tel' => $request->tel,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "data" => $usuario,
            "status" => "success"
        ], 201);
    }

    public function show(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                "message" => "Usuario no encontrado",
                "status" => "error"
            ], 404);
        }

        return response()->json([
            "data" => $usuario,
            "status" => "success"
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                "message" => "Usuario no encontrado",
                "status" => "error"
            ], 404);
        }

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

        return response()->json([
            "data" => $usuario,
            "status" => "success"
        ], 200);
    }

    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                "error" => "USUARIO NO ENCONTRADO",
                "status" => "error"
            ], 404);
        }

        DB::transaction(function () use ($usuario) {
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

            DB::table('sessions')
                ->where('user_id', $usuario->id)
                ->delete();

            DB::table('users')
                ->where('id', $usuario->id)
                ->delete();
        });

        return response()->json([
            "status" => "success",
            "message" => "Registro eliminado correctamente"
        ], 200);
    }
}