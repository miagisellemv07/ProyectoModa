<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class suscripcione extends Model
{
    protected $fillable = [
    'emprendedor_id',
    'precio_mensual',
    'fecha_inicio',
    'fecha_fin',
    'estado'
];
}
