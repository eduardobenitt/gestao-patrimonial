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
    // 1. Máquinas
    public function machines()
    {
        $filename = 'machines_' . now()->format('Ymd_His') . '.csv';
        $machines = Maquina::select('id', 'patrimonio', 'fabricante', 'status')->get();

        $callback = function () use ($machines) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'patrimonio', 'fabricante', 'status']);
            foreach ($machines as $m) {
                fputcsv($out, $m->toArray());
            }
            fclose($out);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ]);
    }

    // 2. Equipamentos
    public function equipments()
    {
        $filename = 'equipments_' . now()->format('Ymd_His') . '.csv';
        $eqs = Equipamento::select('id', 'patrimonio', 'fabricante', 'maquina_id')->get();

        $callback = function () use ($eqs) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'patrimonio', 'fabricante', 'maquina_id']);
            foreach ($eqs as $e) {
                fputcsv($out, $e->toArray());
            }
            fclose($out);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ]);
    }

    // 3. Histórico de alterações
    public function history()
    {
        $filename = 'history_' . now()->format('Ymd_His') . '.csv';
        $hist = HistoricoAlteracao::select('descricao', 'user_id', 'maquina_id', 'equipamento_id', 'alterado_em')->get();

        $callback = function () use ($hist) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['descricao', 'user_id', 'maquina_id', 'equipamento_id', 'alterado_em']);
            foreach ($hist as $h) {
                fputcsv($out, $h->toArray());
            }
            fclose($out);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ]);
    }
}
