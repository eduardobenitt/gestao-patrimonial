<?php

namespace App\Services;

use App\Models\HistoricoAlteracao;

class HistoricoAlteracaoService
{

    public function registrar(string $descricao, ?int $userId = null, ?int $maquinaId = null, ?int $equipamentoId = null)
    {
        return HistoricoAlteracao::create([
            'descricao' => $descricao,
            'user_id' => $userId,
            'maquina_id' => $maquinaId,
            'equipamento_id' => $equipamentoId,
            'alterado_em' => now(),
        ]);
    }
}
