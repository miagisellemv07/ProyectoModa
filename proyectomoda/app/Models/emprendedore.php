<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\tienda;

class emprendedore extends Model
{
    protected $table = 'emprendedores';

    protected $fillable = [
        'usuario_id',
        'nombre_marca'
    ];

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con tiendas
    public function tiendas()
    {
        return $this->hasMany(tienda::class, 'emprendedor_id');
    }
}