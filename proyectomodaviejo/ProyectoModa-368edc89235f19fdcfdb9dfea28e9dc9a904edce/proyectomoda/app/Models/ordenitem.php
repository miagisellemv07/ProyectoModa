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

    public function orden()
    {
        return $this->belongsTo(ordene::class, 'orden_id');
    }

    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }

    public function tienda()
    {
        return $this->belongsTo(tienda::class, 'tienda_id');
    }
}