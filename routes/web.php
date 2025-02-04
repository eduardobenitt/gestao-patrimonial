<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\FabricanteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\HistoricoAlteracaoController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);

   
    Route::resource('maquinas', MaquinaController::class);

    Route::resource('equipamentos', EquipamentoController::class);

    Route::resource('produtos', ProdutoController::class);


    Route::resource('historico-alteracoes', HistoricoAlteracaoController::class);
});


require __DIR__.'/auth.php';
