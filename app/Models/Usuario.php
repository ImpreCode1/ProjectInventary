<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Usuario extends Authenticatable
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'nombres',
        'apellidos',
        'imagen',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    
    }

    public function movimientosProducto()
    {
        return $this->hasMany(MovimientoProducto::class, 'idUsuario');
    }
}
