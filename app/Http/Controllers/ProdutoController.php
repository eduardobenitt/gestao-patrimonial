<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    
    public function index()
    {   
        $produtos = Produto::orderBy('id')->get();
        return view("produtos.index",compact('produtos'));
    }

    
    public function create()
    {
        return view("produtos.create");
    }

    
    public function store(Request $request)
    {   try{
            
            if (Produto::where('nome', $request->nome)->exists()) {
                return redirect()->back()->withErrors(['nome' => 'O nome já está em uso.'])->withInput();
            }
            

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
            ]);

            $produto = Produto::create([
                'nome' => $validated['nome'],
            ]);

            return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
        }catch(\Exception $e){
            return  redirect()->back()->withErrors(['error' => 'Erro ao cadastrar produto.'])->withInput();
        }
    }

    
    public function show(string $id)
    {
        //
    }

    public function edit(Produto $produto){
        
        return view('produtos.edit',compact('produto'));
    }


    public function update(Request $request, Produto $produto){

        if (Produto::where('nome', $request->nome)->where('id', '!=', $produto->id)->exists()) {
            return redirect()->back()->withErrors(['nome' => 'O nome já está em uso.'])->withInput();
        }

        try{
            $validated =  $request->validate([
                'nome'=>'required|string|max:255',
            ]);
    
            $produto->update($validated);
    
            return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');    
        } catch(\Exception $e) {
            return  redirect()->back()->withErrors(['error' => 'Erro ao atualizar produto.'])->withInput();  
        }

    }

    
    public function destroy(Request $request, Produto $produto){
        
        $produto -> delete();

        return redirect()->route('produtos.index')->with('success','Produto excluído com sucesso!');
    }
}
