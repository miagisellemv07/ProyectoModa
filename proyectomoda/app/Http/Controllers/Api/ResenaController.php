<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resena;
use App\Models\cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{

    public function index($productoId)
    {

        $resenas =
            Resena::with([
                'cliente.usuario_id'
            ])

            ->where(
                'producto_id',
                $productoId
            )

            ->latest()

            ->get();

        return response()->json($resenas);

    }



    public function store(Request $request)
    {

        $request->validate([

            'producto_id' =>
                'required|exists:productos,id',

            'calificacion' =>
                'required|integer|min:1|max:5',

            'comentario' =>
                'required|string|min:3'

        ]);


        $cliente =
            cliente::where(
                'usuario_id',
                Auth::id()
            )->first();



        $resena =
            Resena::create([

                'producto_id' =>
                    $request->producto_id,

                'cliente_id' =>
                    $cliente->id,

                'calificacion' =>
                    $request->calificacion,

                'comentario' =>
                    $request->comentario,

                'puntos_ganados' =>
                    10

            ]);


        return response()->json([

            'mensaje' =>
                'Reseña agregada',

            'puntos' =>
                10,

            'data' =>
                $resena

        ]);

    }

}