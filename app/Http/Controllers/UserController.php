<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\Translation\CatalogueMetadataAwareInterface;
use App\Mail\UserInactivatedMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::orderBy('name')->get();
        return view("users.index", compact('users'));
    }


    public function create()
    {
        return view("users.create");
    }


    public function store(Request $request)
    {
        try {

            if (User::where('name', $request->name)->exists()) {
                return redirect()->back()->withErrors(['name' => 'O nome já está em uso.'])->withInput();
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'funcao' => 'nullable|string|max:255',
                'equipe' => 'nullable|string|max:255',
                'ramal' => 'nullable|string|max:20',
                'turno' => 'required|in:Integral,Manhã,Tarde',
                'unidade' => 'nullable|string|max:255',
                'role' => 'required|in:usuario,tecnico,admin',
                'status' => 'nullable|in:Ativo,Inativo',
                'regime' => 'required|in:In Office,Home Office,Hibrido,Prestador'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'funcao' => $validated['funcao'] ?? null,
                'equipe' => $validated['equipe'] ?? null,
                'ramal' => $validated['ramal'] ?? null,
                'turno' => $validated['turno'] ?? 'Integral',
                'unidade' => $validated['unidade'] ?? null,
                'role' => $validated['role'],
                'status' => $validated['status'] ?? 'Ativo',
                'regime' => $validated['regime'] ?? 'In Office',
            ]);

            return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar usuário.'])->withInput();
        }
    }


    public function show(User $user)
    {
        // Obtém o ID do usuário autenticado
        $authUserId = auth('web')->id();

        // Se o usuário está tentando ver dados de outro usuário, redireciona para seus próprios dados
        if ($authUserId !== $user->id) {
            return redirect()->route('users.show', $authUserId)
                ->with('info', 'Você só pode visualizar suas próprias informações nesta página.');
        }

        // Carrega as máquinas e equipamentos em uma única consulta
        $user->load('maquina.equipamentos.produto');

        // Obtém as máquinas pré-carregadas
        $maquinas = $user->maquina;

        // Cria uma coleção vazia para armazenar todos os equipamentos
        $equipamentos = collect();

        // Itera sobre cada máquina para obter seus equipamentos
        foreach ($maquinas as $maquina) {
            if ($maquina->equipamentos && $maquina->equipamentos->count() > 0) {
                $equipamentos = $equipamentos->merge($maquina->equipamentos);
            }
        }

        return view('users.show', compact('user', 'maquinas', 'equipamentos'));
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {

        try {

            if (User::where('name', $request->name)->where('id', '!=', $user->id)->exists()) {
                return redirect()->back()->withErrors(['name' => 'O nome já está em uso.'])->withInput();
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'funcao' => 'nullable|string|max:255',
                'equipe' => 'nullable|string|max:255',
                'ramal' => 'nullable|string|max:20',
                'turno' => 'nullable|in:Integral,Manhã,Tarde',
                'unidade' => 'nullable|string|max:255',
                'role' => 'required|in:usuario,tecnico,admin',
                'status' => 'required|in:Ativo,Inativo',
                'regime' => 'required|in:In Office,Home Office,Hibrido,Prestador'
            ]);

            $user->update($validated);

            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao editar usuário.'])->withInput();
        }
    }


    public function destroy(Request $request, User $user)
    {

        $user->delete();


        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }

    public function inactivate(User $user)
    {
        $user->update([
            'status' => 'Inativo',
        ]);

        // montar lista de patrimônios
        $patrimonios = [];
        foreach ($user->maquinas as $maquina) {
            $patrimonios[] = "Máquina: {$maquina->patrimonio}";
            foreach ($maquina->equipamentos as $eq) {
                $patrimonios[] = "Equipamento: {$eq->patrimonio}";
            }
        }

        // 2. Buscar todos os admins
        $admins = User::where('role', 'admin')->get();

        // 3. Disparar e-mail em background para cada admin
        Mail::to($admins)
            ->queue(new UserInactivatedMail($user, $patrimonios));


        return redirect()->route('users.index')->with('success', 'Usuário inativado com sucesso!');
    }

    public function inativados()
    {
        $users = User::orderBy('name')->get();
        return view("users.inativados", compact('users'));
    }
}
