<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unidadCompuesta extends Model
{
    use HasFactory;

    protected $table = 'unidades_compuestas';

    protected $fillable = [
        'unidaad_compuesta_id',
        'unidad_simple_id',
        'cantidad'
    ];
}
