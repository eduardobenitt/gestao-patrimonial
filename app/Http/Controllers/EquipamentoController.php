<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;

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
        //
    }

    
    public function store(Request $request)
    {
        //
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
