<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view("users.index",compact('users'));
    }

    
    public function create()
    {
        return view("users.create");
    }

    
    public function store(Request $request){
        try{
            
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
                'turno' => 'nullable|in:Integral,Manhã,Tarde',
                'unidade' => 'nullable|string|max:255',
                'role' => 'required|in:usuario,tecnico,admin',
                'status' => 'nullable|in:Ativo,Inativo',
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
            ]);
    
            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar usuário.'])->withInput();
        }
        
    }

   
    public function show(string $id)
    {
        //
    }

    public function edit(User $user){
        return view('users.edit',compact('user'));
    }

 
    public function update(Request $request, User $user){

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
    ]);

    $user->update($validated);

    return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');

    }

  
    public function destroy(Request $request, User $user){
        
        $user -> delete();
        

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }

    public function inactivate(User $user){
        $user -> update([
            'status' => 'Inativo',
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário inativado com sucesso!');
    }

}
