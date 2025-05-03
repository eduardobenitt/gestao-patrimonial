<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Maquina;
use App\Models\Produto;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

use function Pest\Laravel\get;

class EquipamentoController extends Controller
{

    public function index()
    {
        $equipamentos = Equipamento::orderBy('patrimonio')->get();
        return view("equipamentos.index", compact("equipamentos"));
    }


    public function create()
    {
        $maquinas = Maquina::orderBy('patrimonio')->get();
        $produtos = Produto::orderBy('nome')->get();
        return view('equipamentos.create', compact('maquinas', 'produtos'));
    }


    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'patrimonio' => 'required|string|unique:equipamentos,patrimonio|max:255',
                'produto_id' => 'required|exists:produtos,id',
                'fabricante' => 'nullable|string|max:255',
                'especificacoes' => 'nullable|string',
                'status' => 'required|in:Almoxarifado,Em Uso',
                'maquina_id' => 'nullable|exists:maquinas,id',
            ]);

            if ($validated['status'] === 'Em Uso' && empty($validated['maquina_id'])) {
                return redirect()->back()->withErrors(['maquina_id' => 'É necessário selecionar uma máquina para equipamentos "Em Uso".'])->withInput();
            }

            Equipamento::create($validated);

            return redirect()->route('patrimonios.index')->with('success', 'Equipamento cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar equipamento.'])->withInput();
        }
    }



    public function show(string $id)
    {
        //
    }


    public function edit(Equipamento $equipamento)
    {
        $maquinas = Maquina::orderBy('patrimonio')->get();
        $produtos = Produto::orderBy('nome')->get();
        return view('equipamentos.edit', compact('equipamento', 'produtos', 'maquinas'));
    }


    public function update(Request $request, Equipamento $equipamento)
    {
        try {

            $validated = $request->validate([
                'patrimonio' => 'required|string|unique:equipamentos,patrimonio,' . $equipamento->id,
                'fabricante' => 'nullable|string|max:255',
                'especificacoes' => 'nullable|string|max:255',
                'maquina_id' => 'nullable|exists:maquinas,id',
                'produto_id' => 'nullable|exists:produtos,id',
                'status' => 'nullable|in:Almoxarifado,Em Uso',
            ]);

            if ($validated['status'] === 'Em Uso' && empty($validated['maquina_id'])) {
                return redirect()->back()->withErrors(['maquina_id' => 'Uma máquina deve ser selecionada para equipamentos "Em Uso".'])->withInput();
            }

            $equipamento->update($validated);

            return redirect()->route('patrimonios.index')->with('success', 'Equipamento atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao editar equipamento.'])->withInput();
        }
    }


    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();

        return redirect()->route('equipamentos.index')->with('success', 'Equipamento Excluído com sucesso!');
    }
}
