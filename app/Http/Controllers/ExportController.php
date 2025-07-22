<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Machine;
use App\Models\Equipment;
use App\Models\HistoricoAlteracao;
use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function machines()
    {
        $filename = 'maquinas_' . now()->format('Ymd_His') . '.csv';

        $machines = Maquina::with('user')->get();

        $callback = function () use ($machines) {
            $out = fopen('php://output', 'w');

            // Adiciona BOM para UTF-8
            fwrite($out, "\xEF\xBB\xBF");

            // Cabeçalho do CSV
            fputcsv($out, ['ID', 'Patrimônio', 'Fabricante', 'Status', 'Usuário Responsável']);

            foreach ($machines as $m) {
                fputcsv($out, [
                    $m->id,
                    $m->patrimonio,
                    $m->fabricante,
                    $m->status,
                    $m->user->name ?? 'Almoxarifado',
                ]);
            }

            fclose($out);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ]);
    }


    public function equipments()
    {
        $filename = 'equipamentos_' . now()->format('Ymd_His') . '.csv';

        $eqs = Equipamento::with('maquina')->get();

        $callback = function () use ($eqs) {
            $out = fopen('php://output', 'w');

            // Adiciona BOM para UTF-8
            fwrite($out, "\xEF\xBB\xBF");

            // Cabeçalho do CSV
            fputcsv($out, ['ID', 'Patrimônio do Equipamento', 'Fabricante', 'Máquina (Patrimônio)']);

            foreach ($eqs as $e) {
                fputcsv($out, [
                    $e->id,
                    $e->patrimonio,
                    $e->fabricante,
                    $e->maquina->patrimonio ?? 'Almoxarifado',
                ]);
            }

            fclose($out);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ]);
    }


    // 3. Histórico de alterações
    public function history()
    {
        $filename = 'history_' . now()->format('Ymd_His') . '.csv';
        $hist = HistoricoAlteracao::with(['user'], ['maquina'], ['equipamento'])->get();

        $callback = function () use ($hist) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['Descrição', 'Usuário', 'Máquina', 'Equipamento', 'Data']);

            foreach ($hist as $h) {
                fputcsv($out, [
                    $h->descricao,
                    $h->user->name ?? 'N/A',
                    $h->maquina->patrimonio ?? 'N/A',
                    $h->equipamento->patrimonio ?? 'N/A',
                    $h->alterado_em,
                ]);
            }

            fclose($out);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ]);
    }
}
