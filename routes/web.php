<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
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
});

Route::middleware('auth')->group(function () {
    Route::get('/', [JobController::class, 'home'])->name('home');

    Route::get('/cadastrar_vaga', [JobController::class, 'vaga'])->name('cadastrar_vaga');

    Route::post('/cadastrar_vaga', [JobController::class, 'vagaSubmit'])->name('cadastrar_vagaSubmit');

    Route::get('/editar_vaga/{vaga}', [JobController::class, 'editar'])->name('editar_vaga');

    Route::post('/editar_vaga/{vaga}', [JobController::class, 'editarSubmit'])->name('editar_vagaSubmit');
    
    Route::delete('/deletar_vaga/{vaga}', [JobController::class, 'deletar'])->name('deletar_vaga');
});


require __DIR__.'/auth.php';
