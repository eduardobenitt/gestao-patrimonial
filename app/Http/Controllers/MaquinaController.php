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
use Illuminate\Contracts\Mail\Attachable;

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
            ->paginate(15);
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

            // Regras específicas por tipo de status
            if ($request->status === 'Colaborador Integral') {
                $rules['usuario_integral'] = 'required|exists:users,id';
            } elseif ($request->status === 'Colaborador Meio Período') {
                $rules['usuario_manha'] = 'nullable|exists:users,id';
                $rules['usuario_tarde'] = 'nullable|exists:users,id';
            }

            $validated = $request->validate($rules);

            // Validação adicional para meio período - pelo menos um usuário informado
            if ($validated['status'] === 'Colaborador Meio Período') {
                if (empty($request->usuario_manha) && empty($request->usuario_tarde)) {
                    return redirect()->back()
                        ->withErrors(['usuarios' => 'Pelo menos um usuário (manhã ou tarde) deve ser informado.'])
                        ->withInput();
                }
            }

            $maquina = Maquina::create([
                'patrimonio' => $validated['patrimonio'],
                'fabricante' => $validated['fabricante'] ?? null,
                'especificacoes' => $validated['especificacoes'] ?? null,
                'tipo' => $validated['tipo'],
                'status' => $validated['status'],
            ]);

            // Vinculação de usuários com base no status
            $actor = auth('web')->user();
            $descricao = $actor->name . ' - ' . HistoricoAlteracao::ATRIBUICAO;


            if ($validated['status'] === 'Colaborador Integral') {
                // Vincula um único usuário para colaborador integral
                $maquina->usuarios()->attach($validated['usuario_integral'], ['turno' => null]);
                $userId = $validated['usuario_integral'];
            } elseif ($validated['status'] === 'Colaborador Meio Período') {
                // Vincula usuários para os turnos da manhã e tarde, se informados
                $userIds = [];

                if (!empty($request->usuario_manha)) {
                    $maquina->usuarios()->attach($request->usuario_manha, ['turno' => 'manha']);
                    $userIds[] = $request->usuario_manha;
                }

                if (!empty($request->usuario_tarde)) {
                    $maquina->usuarios()->attach($request->usuario_tarde, ['turno' => 'tarde']);
                    $userIds[] = $request->usuario_tarde;
                }
            }


            // Vinculação de equipamentos
            if ($request->has('equipamentos_ids') && is_array($request->equipamentos_ids)) {
                foreach ($request->equipamentos_ids as $equipamentoID) {
                    $equipamento = Equipamento::find($equipamentoID);
                    if ($equipamento) {
                        $equipamento->update([
                            'maquina_id' => $maquina->id,
                            'status' => 'Em Uso',
                        ]);

                        // Registro no histórico
                        if ($validated['status'] === 'Colaborador Integral') {
                            $this->historicoService->registrar(
                                $descricao,
                                $validated['usuario_integral'],
                                $maquina->id,
                                $equipamento->id
                            );
                        } elseif ($validated['status'] === 'Colaborador Meio Período') {
                            // Registra para cada usuário vinculado
                            foreach ($userIds as $userId) {
                                $this->historicoService->registrar(
                                    $descricao,
                                    $userId,
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
        $equipamentos = Equipamento::whereNull('maquina_id')->orWhere('maquina_id', $maquina->id)->orderBy('patrimonio')->get();
        $usuariosDisponiveis = User::orderBy('name')->get();
        return view('maquinas.edit', compact('maquina', 'usuariosDisponiveis', 'equipamentos'));
    }

    public function update(Request $request, Maquina $maquina)
    {
        // Iniciamos a transação
        return DB::transaction(function () use ($request, $maquina) {
            try {
                // 1. Validação (esta parte está correta)
                $rules = [
                    'patrimonio'    => 'required|string|max:255|unique:maquinas,patrimonio,' . $maquina->id,
                    'fabricante'    => 'nullable|string|max:25',
                    'especificacoes' => 'nullable|string|max:255',
                    'tipo'          => 'required|in:notebook,desktop',
                    'status'        => 'required|in:Almoxarifado,Colaborador Integral,Colaborador Meio Período',
                ];

                // Regras específicas por tipo de status
                if ($request->status === 'Colaborador Integral') {
                    $rules['usuario_integral'] = 'required|exists:users,id';
                } elseif ($request->status === 'Colaborador Meio Período') {
                    $rules['usuario_manha'] = 'nullable|exists:users,id';
                    $rules['usuario_tarde'] = 'nullable|exists:users,id';
                }

                if ($request->has('equipamentos_ids')) {
                    $rules['equipamentos_ids']   = 'array';
                    $rules['equipamentos_ids.*'] = 'exists:equipamentos,id';
                }

                $validated = $request->validate($rules);

                // Validação adicional para meio período - pelo menos um usuário informado
                if ($validated['status'] === 'Colaborador Meio Período') {
                    if (empty($request->usuario_manha) && empty($request->usuario_tarde)) {
                        return redirect()->back()
                            ->withErrors(['usuarios' => 'Pelo menos um usuário (manhã ou tarde) deve ser informado.'])
                            ->withInput();
                    }
                }

                // 2. Descobrir equipamentos removidos/adicionados
                $oldEquipIds = $maquina->equipamentos->pluck('id')->toArray();
                $newEquipIds = $request->equipamentos_ids ?? [];

                $removedEquipIds = array_diff($oldEquipIds, $newEquipIds);
                $addedEquipIds   = array_diff($newEquipIds, $oldEquipIds);

                // 3. Gerenciar equipamentos com base no status
                if ($validated['status'] === 'Almoxarifado') {
                    // Se Almoxarifado, removemos todos os equipamentos
                    $removedEquipIds = $oldEquipIds;
                    Equipamento::where('maquina_id', $maquina->id)
                        ->update([
                            'maquina_id' => null,
                            'status'     => 'Almoxarifado',
                        ]);
                } else {
                    // Remover só o que saiu
                    Equipamento::whereIn('id', $removedEquipIds)
                        ->update([
                            'maquina_id' => null,
                            'status'     => 'Almoxarifado',
                        ]);

                    // Adicionar só o que entrou
                    if (!empty($addedEquipIds)) {
                        Equipamento::whereIn('id', $addedEquipIds)
                            ->update([
                                'maquina_id' => $maquina->id,
                                'status'     => 'Em Uso',
                            ]);
                    }
                }

                // 4. Atualizar a máquina
                $maquina->update([
                    'patrimonio'     => $validated['patrimonio'],
                    'fabricante'     => $validated['fabricante'] ?? null,
                    'especificacoes' => $validated['especificacoes'] ?? null,
                    'tipo'           => $validated['tipo'],
                    'status'         => $validated['status'],
                ]);

                // 5. Gerenciar usuários
                $actor = auth('web')->user();
                $descricaoAtrib = $actor->name . ' - ' . HistoricoAlteracao::ATRIBUICAO;
                $descricaoDes = $actor->name . ' - ' . HistoricoAlteracao::DESATRIBUICAO;

                $atuaisUsuarios = $maquina->usuarios()
                    ->withPivot('turno')
                    ->get()
                    ->keyBy('id')
                    ->toArray();

                // Preparar a nova lista de usuários com seus turnos
                $novosUsuarios = [];

                if ($validated['status'] === 'Almoxarifado') {
                    // Não tem usuários no almoxarifado
                } elseif ($validated['status'] === 'Colaborador Integral') {
                    if (!empty($validated['usuario_integral'])) {
                        $novosUsuarios[$validated['usuario_integral']] = [
                            'turno' => null
                        ];
                    }
                } elseif ($validated['status'] === 'Colaborador Meio Período') {
                    if (!empty($request->usuario_manha)) {
                        $novosUsuarios[$request->usuario_manha] = [
                            'turno' => 'manha'
                        ];
                    }

                    if (!empty($request->usuario_tarde)) {
                        $novosUsuarios[$request->usuario_tarde] = [
                            'turno' => 'tarde'
                        ];
                    }
                }

                // Processar usuários atuais (remover ou atualizar)
                foreach ($atuaisUsuarios as $userId => $userData) {
                    if (!array_key_exists($userId, $novosUsuarios)) {
                        // Usuário não está mais associado - remove
                        $maquina->usuarios()->detach($userId);
                        $this->historicoService->registrar($descricaoDes, $userId, $maquina->id, null);
                    } elseif ($userData['pivot']['turno'] !== $novosUsuarios[$userId]['turno']) {
                        // Usuário continua, mas mudou de turno - atualiza
                        $maquina->usuarios()->updateExistingPivot($userId, [
                            'turno' => $novosUsuarios[$userId]['turno']
                        ]);
                        // Opcional: registrar mudança de turno no histórico
                    }
                    // Se não caiu em nenhuma condição, o usuário continua com o mesmo turno
                }

                // Adicionar novos usuários
                foreach ($novosUsuarios as $userId => $userData) {
                    if (!array_key_exists($userId, $atuaisUsuarios)) {
                        // Novo usuário - adiciona
                        $maquina->usuarios()->attach($userId, [
                            'turno' => $userData['turno']
                        ]);
                        $this->historicoService->registrar($descricaoAtrib, $userId, $maquina->id, null);
                    }
                }

                // 6. Histórico para equipamentos
                $userIds = array_keys($novosUsuarios);
                if ($validated['status'] === 'Almoxarifado') {
                    // Desatribui tudo
                    foreach ($removedEquipIds as $equipId) {
                        $this->historicoService->registrar($descricaoDes, null, $maquina->id, $equipId);
                    }
                } else {
                    // Desatribuição
                    foreach ($userIds as $uId) {
                        foreach ($removedEquipIds as $equipId) {
                            $this->historicoService->registrar($descricaoDes, $uId, $maquina->id, $equipId);
                        }
                    }

                    // Atribuição
                    foreach ($userIds as $uId) {
                        foreach ($addedEquipIds as $equipId) {
                            $this->historicoService->registrar($descricaoAtrib, $uId, $maquina->id, $equipId);
                        }
                    }
                }

                // Se tudo deu certo, confirmamos a transação
                return redirect()->route('patrimonios.index')->with('success', 'Máquina atualizada com sucesso!');
            } catch (\Exception $e) {
                // Em caso de erro, a transação será revertida (rollback)
                throw $e;
            }
        });
    }




    public function destroy(Request $request, Maquina $maquina)
    {
        try {
            // Verificar se existem equipamentos vinculados
            $hasEquipamentos = $maquina->equipamentos->count() > 0;

            DB::transaction(function () use ($maquina) {
                // Obter usuário atual
                $actor = auth('web')->user();
                $descricaoDes = $actor->name . ' - Exclusão de Máquina - ' . HistoricoAlteracao::DESATRIBUICAO;

                // Atualizar equipamentos para Almoxarifado
                foreach ($maquina->equipamentos as $equipamento) {
                    $equipamento->update([
                        'maquina_id' => null,
                        'status' => 'Almoxarifado',
                    ]);

                    // Registrar no histórico
                    $this->historicoService->registrar(
                        $descricaoDes,
                        null,
                        $maquina->id,
                        $equipamento->id
                    );
                }

                // Desvincular usuários e registrar no histórico
                foreach ($maquina->usuarios as $usuario) {
                    $this->historicoService->registrar(
                        $descricaoDes,
                        $usuario->id,
                        $maquina->id,
                        null
                    );
                }

                // Desvincular usuários
                $maquina->usuarios()->detach();

                // Excluir a máquina
                $maquina->delete();
            });

            // Mensagem de sucesso
            $message = 'Maquina excluída com Sucesso!';
            if ($hasEquipamentos) {
                $message .= ' Equipamentos vinculados a máquina foram enviados para o almoxarifado.';
            }

            return redirect()->route('patrimonios.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao excluir a máquina.'])->withInput();
        }
    }
}
