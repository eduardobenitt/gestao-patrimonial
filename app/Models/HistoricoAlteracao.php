<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoAlteracao extends Model
{
    use HasFactory;

    protected $table = 'historico_alteracoes';

    protected $fillable = [
        'descricao',
        'user_id',
        'maquina_id',
        'equipamento_id',
        'alterado_em',
    ];

    public const ATRIBUICAO = 'Atribuição';
    public const DESATRIBUICAO = 'Desatribuição';
    public const DESLIGADO = 'Desligado';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
