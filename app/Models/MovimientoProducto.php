<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoProducto extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'movimientos_productos';
    protected $fillable =['cantidadUsada','idProducto','idUsuario','fecha'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }

    public function infoMovimiento()
    {
        return $this->hasOne(InfoMovimiento::class, 'idMovimientoProducto');
    }
}
