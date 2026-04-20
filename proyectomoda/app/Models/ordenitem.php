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
public function orden_id(){
        return $this->belongsTo(ordene::class);
    }
public function producto_id(){
        return $this->belongsTo(producto::class);
    }
public function tienda_id(){
        return $this->belongsTo(tienda::class);
    }
}
