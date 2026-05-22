<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    protected $table = 'resenas';

    protected $fillable = [
        'producto_id',
        'cliente_id',
        'calificacion',
        'comentario',
        'puntos_ganados'
    ];

    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(cliente::class, 'cliente_id');
    }
}