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

    public function cliente()
    {
        return $this->belongsTo(cliente::class, 'cliente_id');
    }

    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }
}