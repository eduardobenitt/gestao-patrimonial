<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\DashboardController;
use App\Models\Equipamento;
use App\Models\Maquina;
use App\Models\Produto;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');



Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
    
    Route::middleware('can:create,App\Models\User')->group(function () {
        
        Route::patch('users/{user}/promote', [UserController::class, 'promoteToTecnico'])->name('users.promote');
    });

    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::get('/maquinas/index', [MaquinaController::class, 'index'])->name('maquinas.index');
    Route::get('/equipamentos/index', [EquipamentoController::class, 'index'])->name('equipamentos.index');
    Route::get('/produtos/index', [ProdutoController::class, 'index'])->name('produtos.index');
});

require __DIR__.'/auth.php';
