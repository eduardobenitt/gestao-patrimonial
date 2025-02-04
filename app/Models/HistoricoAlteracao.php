<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoAlteracao extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'descricao',
        'data',
        'usuario_id',
        'referencia_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
