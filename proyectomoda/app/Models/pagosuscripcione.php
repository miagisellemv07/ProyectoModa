<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pagosuscripcione extends Model
{
    protected $fillable = [
    'suscripcion_id',
    'monto',
    'metodo_pago',
    'fecha_pago'
];
}
