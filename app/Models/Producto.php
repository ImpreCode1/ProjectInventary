<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $fillable = ['nombre','descripcion','imagen','cantidad','idCategoria','unidad_medida_id','cantidad_minima','fecharegistro','cantidad_unidad_compuesta','cantidad_total'];


    public function UnidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria')->withDefault();
    }

    public function movimientosProducto()
    {
        return $this->hasMany(MovimientoProducto::class,'idProducto');
    }
}
