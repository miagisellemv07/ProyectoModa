<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resena;
use App\Models\cliente;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ResenaController extends Controller
{
    public function index($productoId)
    {
        $resenas = Resena::with([
                'cliente.usuario'
            ])
            ->where('producto_id', $productoId)
            ->latest()
            ->get();

        return response()->json($resenas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:3'
        ]);

        $usuario = JWTAuth::parseToken()->authenticate();

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $cliente = cliente::firstOrCreate(
            ['usuario_id' => $usuario->id],
            ['direccion' => 'Sin dirección']
        );

        $resena = Resena::create([
            'producto_id' => $request->producto_id,
            'cliente_id' => $cliente->id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'puntos_ganados' => 10
        ]);

        return response()->json([
            'mensaje' => 'Reseña agregada',
            'puntos' => 10,
            'data' => $resena
        ], 201);
    }
}