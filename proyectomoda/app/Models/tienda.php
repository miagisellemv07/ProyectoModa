<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tienda extends Model
{
    protected $table = 'tiendas';

    protected $fillable = [
        'emprendedor_id',
        'nombre',
        'logo',
        'descripcion',
        'categoria'
    ];
   

    public function emprendedor()
    {
        return $this->belongsTo(emprendedore::class, 'emprendedor_id');
    }

    public function productos()
    {
        return $this->hasMany(producto::class, 'tienda_id');
    }
}