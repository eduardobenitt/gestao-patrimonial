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


Route::redirect('/', '/users');


Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can:create,App\Models\User')->group(function () {

        Route::patch('users/{user}/promote', [UserController::class, 'promoteToTecnico'])->name('users.promote');
    });

    Route::post('users/{user}/inactivate', [UserController::class, 'inactivate'])->name('users.inactivate');
    Route::get('users/inativados', [UserController::class, 'inativados'])->name('users.inativados');
    Route::resource('users', UserController::class)->where(['user' => '[0-9]+']);
    Route::get('/patrimonios', [App\Http\Controllers\PatrimonioController::class, 'index'])->name('patrimonios.index');



    Route::resource('produtos', ProdutoController::class);
    Route::resource('maquinas', MaquinaController::class);
    Route::resource('equipamentos', EquipamentoController::class);

    // routes/web.php
    Route::get('export/machines',  [\App\Http\Controllers\ExportController::class, 'machines'])
        ->name('export.machines');

    Route::get('export/equipments', [\App\Http\Controllers\ExportController::class, 'equipments'])
        ->name('export.equipments');

    Route::get('export/changes',   [\App\Http\Controllers\ExportController::class, 'history'])
        ->name('export.changes');
});

require __DIR__ . '/auth.php';
