<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ordenitem extends Model
{
    protected $fillable = [
    'orden_id',
    'producto_id',
    'tienda_id',
    'cantidad',
    'precio_unitario',
    'subtotal'
];
}
