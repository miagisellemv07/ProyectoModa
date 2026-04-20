<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    protected $fillable = [
    'usuario_id',
    'direccion'
];
public function usuario_id(){
        return $this->belongsTo(User::class);
    }
}
