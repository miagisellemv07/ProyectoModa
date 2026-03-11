<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tienda extends Model
{
    protected $fillable = [
    'emprendedor_id',
    'nombre',
    'logo',
    'descripcion',
    'categoria'
];
}
