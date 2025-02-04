<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'patrimonio',
        'marca',
        'especificacoes',
        'status',
        'user_id', // Chave estrangeira relacionada ao usuário
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }
}
