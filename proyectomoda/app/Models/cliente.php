<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $fillable = [
        'usuario_id',
        'direccion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class, 'cliente_id');
    }
}