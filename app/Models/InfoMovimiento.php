<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoMovimiento extends Model
{
    use HasFactory;
    protected $table = 'infomovimientos';


    protected $fillable = ['mensaje', 'vicepresidencia','observaciones','idMovimientoProducto'];

    public function movimientoProducto()
    {
        return $this->belongsTo(MovimientoProducto::class, 'idMovimientoProducto');
    }
}
