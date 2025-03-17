<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'funcao',
        'equipe',
        'ramal',
        'turno',
        'email',
        'unidade',
        'status',
        'password',
        'role',  // Permissão do usuário: admin, tecnico, usuario
        'regime',
    ];

    /**
     * Os atributos que devem ser ocultados na serialização.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function maquina()
    {
        return $this->belongsToMany(Maquina::class, 'maquina_user')->withPivot('turno');
    }

    /**
     * Verifica se o usuário é admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o usuário é técnico.
     */
    public function isTecnico()
    {
        return $this->role === 'tecnico';
    }

    /**
     * Verifica se o usuário é um usuário comum.
     */
    public function isUsuario()
    {
        return $this->role === 'usuario';
    }
}
