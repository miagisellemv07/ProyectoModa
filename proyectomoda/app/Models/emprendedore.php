<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class emprendedore extends Model
{
    protected $table = 'emprendedores';

    protected $fillable = [
        'usuario_id',
        'nombre_marca'
    ];
    public function usuario_id()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function tiendas()
    {
        return $this->hasMany(tienda::class, 'emprendedor_id');
    }
}