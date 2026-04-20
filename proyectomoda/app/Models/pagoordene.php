<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pagoordene extends Model
{
    protected $fillable = [
    'orden_id',
    'monto',
    'metodo_pago',
    'estado',
    'fecha_pago'
];
 public function orden_id(){
        return $this->belongsTo(ordene::class);
    }
}
