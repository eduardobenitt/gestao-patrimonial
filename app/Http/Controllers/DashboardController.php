<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(){

        $totalUsuarios = User::count();
        $totalMaquinas = Maquina::count();
        $usuarioPorPermissao = DB::table('users')
        ->select('role', DB::raw('count(*) as total'))
        ->groupBy('role')
        ->get();

        $usuarios = User::with(['maquina'])->get();
        $maquinas = Maquina::with(['usuarios'])->get();

        return view('dashboard', compact('totalUsuarios', 'totalMaquinas', 'usuarioPorPermissao', 'usuarios', 'maquinas'));
    }
}
