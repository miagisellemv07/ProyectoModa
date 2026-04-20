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
public function cliente_id(){
        return $this->belongsTo(cliente::class);
    }
    public function producto_id(){
        return $this->belongsTo(producto::class);
    }
}
