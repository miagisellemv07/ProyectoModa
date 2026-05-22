<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email',
            'tel' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'required|string|confirmed',
        ]);

        $user = DB::transaction(function () use ($request) {
            $usuario = User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'tel' => $request->tel,
                'rol' => 'cliente',
                'password' => Hash::make($request->password),
            ]);

            cliente::create([
                'usuario_id' => $usuario->id,
                'direccion' => $request->direccion ?? 'Sin dirección',
            ]);

            return $usuario;
        });

        try {
            Mail::raw(
                "Hola {$user->nombre}, gracias por registrarte en Virtuality Mall.\n\nTu cuenta fue creada correctamente y ya puedes explorar productos, agregar artículos al carrito y realizar compras.\n\nGracias por formar parte de Virtuality Mall.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Bienvenida a Virtuality Mall');
                }
            );
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de registro: ' . $e->getMessage());
        }

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 500);
        }

        $user = User::find(Auth::user()->id);

        return response()->json([
            'token' => $token,
            'user' => $user,
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Failed to logout, please try again'
            ], 500);
        }

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function getUser()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User not found'
                ], 404);
            }

            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Failed to fetch user profile'
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $user = Auth::user();

            $user->update(
                $request->only([
                    'nombre',
                    'apellido',
                    'email',
                    'tel'
                ])
            );

            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Failed to update user'
            ], 500);
        }
    }
}