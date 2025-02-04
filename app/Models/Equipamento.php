<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'patrimonio',
        'produto',
        'fabricante',
        'especificacoes',
        'maquina_id',
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }
}
