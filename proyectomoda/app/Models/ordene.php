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
}
