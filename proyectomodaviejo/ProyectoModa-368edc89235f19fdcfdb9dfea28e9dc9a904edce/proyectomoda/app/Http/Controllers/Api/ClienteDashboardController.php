<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\cliente;
use App\Models\ordene;
use App\Models\pagoordene;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClienteDashboardController extends Controller
{
    private function obtenerCliente()
    {
        $usuario = JWTAuth::parseToken()->authenticate();

        return cliente::firstOrCreate(
            ['usuario_id' => $usuario->id],
            ['direccion' => 'Sin dirección']
        );
    }

    public function compras()
    {
        $cliente = $this->obtenerCliente();

        $compras = ordene::with([
                'items.producto',
                'pagos'
            ])
            ->where('cliente_id', $cliente->id)
            ->latest()
            ->get();

        return response()->json([
            'data' => $compras,
            'status' => 'success'
        ], 200);
    }

    public function pagos()
    {
        $cliente = $this->obtenerCliente();

        $pagos = pagoordene::with('orden')
            ->whereHas('orden', function ($query) use ($cliente) {
                $query->where('cliente_id', $cliente->id);
            })
            ->latest()
            ->get();

        return response()->json([
            'data' => $pagos,
            'status' => 'success'
        ], 200);
    }
}