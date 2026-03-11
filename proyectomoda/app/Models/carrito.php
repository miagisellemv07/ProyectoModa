<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carrito extends Model
{
    protected $fillable = [
    'cliente_id',
    'producto_id',
    'cantidad',
    'precio_unitario',
    'subtotal'
];
}
