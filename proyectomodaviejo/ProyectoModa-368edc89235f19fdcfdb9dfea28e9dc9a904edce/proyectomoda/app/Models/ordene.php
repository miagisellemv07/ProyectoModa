<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ordene extends Model
{
    protected $fillable = [
        'cliente_id',
        'numero_orden',
        'estado',
        'total',
        'direccion_envio',
        'telefono',
        'notas'
    ];

    public function cliente()
    {
        return $this->belongsTo(cliente::class, 'cliente_id');
    }

    public function pagos()
    {
        return $this->hasMany(pagoordene::class, 'orden_id');
    }

    public function items()
    {
        return $this->hasMany(ordenitem::class, 'orden_id');
    }
}