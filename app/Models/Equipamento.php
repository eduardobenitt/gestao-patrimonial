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
        'status',
        'maquina_id',
        'produto_id',
    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }

    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
