<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'idCategoria');
    }
}