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
        return $this->belongsToMany(User::class, 'maquina_user');
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }
}
