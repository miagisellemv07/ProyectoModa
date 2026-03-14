<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'tienda_id'
    ];

    public function tienda()
    {
        return $this->belongsTo(tienda::class, 'tienda_id');
    }
}