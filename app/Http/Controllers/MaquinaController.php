<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\delete;
use function Pest\Laravel\withCookie;

class MaquinaController extends Controller
{
    public function index()
    {

        $maquinas = Maquina::orderBy('patrimonio')->get();
        return view('maquinas.index', compact('maquinas'));
    }

    public function create()
    {

        $usuariosDisponiveis = \App\Models\User::orderBy('name')->get();
        return view('maquinas.create', compact('usuariosDisponiveis'));
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

        $usuariosDisponiveis = \App\Models\User::orderBy('name')->get();
        return view('maquinas.edit', compact('maquina', 'usuariosDisponiveis'));
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

            $validated = $request->validate($rules);

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
