<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $fillable = [
    'nombre',
    'descripcion',
    'precio',
    'stock',
    'tienda_id'
];
}
