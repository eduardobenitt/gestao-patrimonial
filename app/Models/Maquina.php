<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'patrimonio',
        'fabricante',
        'especificacoes',
        'tipo',
        'status',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'maquina_user')->withPivot('turno');
    }

    public function usuariosIntegrais()
    {
        return $this->belongsToMany(User::class, 'maquina_user')
            ->withPivot('turno')
            ->whereNull('maquina_user.turno');
    }

    public function usuariosManha()
    {
        return $this->belongsToMany(User::class, 'maquina_user')
            ->withPivot('turno')
            ->wherePivot('turno', 'manha');
    }

    public function usuariosTarde()
    {
        return $this->belongsToMany(User::class, 'maquina_user')
            ->withPivot('turno')
            ->wherePivot('turno', 'tarde');
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }
}
