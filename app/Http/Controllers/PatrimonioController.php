<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Equipamento;
use Illuminate\Http\Request;

class PatrimonioController extends Controller
{
    /**
     * Exibe a página combinada de máquinas e equipamentos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Carrega as máquinas com seus relacionamentos
        $maquinas = Maquina::with(['usuarios', 'equipamentos.produto'])
            ->orderBy('patrimonio')
            ->get();

        // Carrega os equipamentos com seus relacionamentos
        $equipamentos = Equipamento::with(['produto', 'maquina.usuarios'])
            ->orderBy('patrimonio')
            ->get();

        return view('patrimonios.index', compact('maquinas', 'equipamentos'));
    }
}
