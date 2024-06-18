<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;


    // protected $primarykey = 'idUsuario';
    protected $hidden = ['senha',];
    protected $fillable = ['nome', 'email', 'senha', 'tipo_usuario_id', 'tipo_usuario_type'];

    public function tipo_usuario()
    {
        return $this->morphTo('tipo_usuario', 'tipo_usuario_type', 'tipo_usuario_id');
    }
}
