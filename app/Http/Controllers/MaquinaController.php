<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'tipo' => 'required|in:notebook, desktop',
                'status' => 'required|in:Almoxarifado,Colaborador Integral, Colaborador Meio Período',
            ];

            if($request->status === 'Colaborador Integral'){
                $rules['usuario_integral'] = 'required|exists:users,id';
            } elseif($request->status === 'Colaborador Meio Período'){
                $rules['usuarios'] = 'required|array|size:2';
                $rules['usuarios.*.id'] = 'required|exists:users,id';
            }

            $validated = $request->validate($rules);

            $maquina = Maquina::create([
                'patrimonio' => $validated['patrimonio'],
                'fabricante' => $validated['fabricante'] ?? null,
                'especificacoes' => $validated['especificacoes'] ?? null,
                'tipo' => $validated['tipo'],
                'status' => $validated['status'],
            ]);

            if($validated['status'] === 'Colaborador Integral'){
                $maquina->usuarios()->attach($validated['usuario_integral']);
            }elseif ($validated['status'] === 'Colaborador Meio Período'){
                $usuarioIds = array_map(function ($item){
                    return $item['id'];
                }, $validated['usuarios']);
                $maquina->usuarios()->attach($usuarioIds);
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
