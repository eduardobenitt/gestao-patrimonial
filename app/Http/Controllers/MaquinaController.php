<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\User;
use App\Models\Equipamento;
use App\Models\HistoricoAlteracao;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HistoricoAlteracaoService;

use function Pest\Laravel\delete;
use function Pest\Laravel\withCookie;

class MaquinaController extends Controller
{
    protected $historicoService;

    public function __construct(HistoricoAlteracaoService $historicoService)
    {
        $this->historicoService = $historicoService;
    }


    public function index()
    {

        $maquinas = Maquina::with(['usuarios', 'equipamentos.produto'])
            ->orderBy('patrimonio')
            ->get();
        return view('maquinas.index', compact('maquinas'));
    }

    public function create()
    {
        $equipamentos = Equipamento::whereNull('maquina_id')->orderBy('patrimonio')->get();
        $usuariosDisponiveis = User::orderBy('name')->get();
        return view('maquinas.create', compact('usuariosDisponiveis', 'equipamentos'));
    }

    public function store(Request $request)
    {

        try {

            $rules = [
                'patrimonio' => 'required|string|unique:maquinas,patrimonio|max:255',
                'fabricante' => 'nullable|string|max:25',
                'especificacoes' => 'nullable|string|max:255',
                'tipo' => 'required|in:notebook,desktop',
                'status' => 'required|in:Almoxarifado,Colaborador Integral,Colaborador Meio Período',
            ];

            if ($request->status === 'Colaborador Integral') {
                $rules['usuario_integral'] = 'required|exists:users,id';
            } elseif ($request->status === 'Colaborador Meio Período') {
                $rules['usuarios'] = 'required|array|size:2';
                $rules['usuarios.*'] = 'required|exists:users,id';
            }

            $validated = $request->validate($rules);

            $maquina = Maquina::create([
                'patrimonio' => $validated['patrimonio'],
                'fabricante' => $validated['fabricante'] ?? null,
                'especificacoes' => $validated['especificacoes'] ?? null,
                'tipo' => $validated['tipo'],
                'status' => $validated['status'],
            ]);

            if ($validated['status'] === 'Colaborador Integral') {
                $maquina->usuarios()->attach($validated['usuario_integral']);
            } elseif ($validated['status'] === 'Colaborador Meio Período') {
                foreach ($validated['usuarios'] as $usuariosIds) {
                    $maquina->usuarios()->attach($usuariosIds);
                }
            }

            $actor = auth('web')->user();
            $descricao = $actor->name . ' - ' . HistoricoAlteracao::ATRIBUICAO;

            if ($request->has('equipamentos_ids') && is_array($request->equipamentos_ids)) {
                foreach ($request->equipamentos_ids as $equipamentoID) {
                    $equipamento = Equipamento::find($equipamentoID);
                    if ($equipamento) {
                        $equipamento->update([
                            'maquina_id' => $maquina->id,
                            'status' => 'Em Uso',
                        ]);
                        if ($validated['status'] === 'Colaborador Integral') {
                            $this->historicoService->registrar(
                                $descricao,
                                $validated['usuario_integral'],
                                $maquina->id,
                                $equipamento->id
                            );
                        } elseif ($validated['status'] === 'Colaborador Meio Período') {
                            foreach ($validated['usuarios'] as $usuariosIds) {
                                $this->historicoService->registrar(
                                    $descricao,
                                    $usuariosIds,
                                    $maquina->id,
                                    $equipamento->id
                                );
                            }
                        }
                    }
                }
            }



            return redirect()->route('maquinas.index')->with('success', 'Máquina cadastrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar Máquina.'])->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Maquina $maquina)
    {
        $equipamentos = Equipamento::orderBy('patrimonio')->get();
        $usuariosDisponiveis = \App\Models\User::orderBy('name')->get();
        return view('maquinas.edit', compact('maquina', 'usuariosDisponiveis', 'equipamentos'));
    }

    public function update(Request $request, Maquina $maquina)
    {
        try {
            $rules = [
                'patrimonio' => 'required|string|max:255|unique:maquinas,patrimonio,' . $maquina->id,
                'fabricante' => 'nullable|string|max:25',
                'especificacoes' => 'nullable|string|max:255',
                'tipo' => 'required|in:notebook,desktop',
                'status' => 'required|in:Almoxarifado,Colaborador Integral,Colaborador Meio Período',
            ];

            if ($request->status === 'Colaborador Integral') {
                $rules['usuario_integral'] = 'required|exists:users,id';
            } elseif ($request->status === 'Colaborador Meio Período') {
                $rules['usuarios'] = 'required|array|size:2';
                $rules['usuarios.*'] = 'required|exists:users,id';
            }

            if ($request->has('equipamentos_ids')) {
                $rules['equipamentos_ids'] = 'array';
                $rules['equipamentos_ids.*'] = 'exists:equipamentos,id';
            }

            $validated = $request->validate($rules);

            Equipamento::where('maquina_id', $maquina->id)
                ->update([
                    'maquina_id' => null,
                    'status' => 'Almoxarifado',
                ]);

            if (!empty($validated['equipamentos_ids'])) {
                Equipamento::whereIn('id', $validated['equipamentos_ids'])
                    ->update([
                        'maquina_id' => $maquina->id,
                        'status' => 'Em Uso',
                    ]);
            }

            // Atualiza os dados da máquina
            $maquina->update([
                'patrimonio' => $validated['patrimonio'],
                'fabricante' => $validated['fabricante'] ?? null,
                'especificacoes' => $validated['especificacoes'] ?? null,
                'tipo' => $validated['tipo'],
                'status' => $validated['status'],
            ]);

            // Atualiza os relacionamentos (limpa os vínculos antigos)
            $maquina->usuarios()->detach();

            if ($validated['status'] === 'Colaborador Integral') {
                $maquina->usuarios()->attach($validated['usuario_integral']);
            } elseif ($validated['status'] === 'Colaborador Meio Período') {
                // $validated['usuarios'] já é um array simples com os IDs
                $maquina->usuarios()->attach($validated['usuarios']);
            }
            // Para status "Almoxarifado", não há vínculo com usuário

            return redirect()->route('maquinas.index')->with('success', 'Máquina atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar a máquina.'])->withInput();
        }
    }



    public function destroy(Request $request, Maquina $maquina)
    {

        try {

            $maquina->usuarios()->detach();

            $maquina->delete();

            return redirect()->route('maquinas.index')->with('success', 'Maquina excluída com Sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao excluir a máquina.'])->withInput();
        }
    }
}
