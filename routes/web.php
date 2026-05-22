<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/cadastrar_vaga', [JobController::class, 'vaga']
)->name('cadastrar_vaga');
Route::post('/cadastrar_vaga', [JobController::class, 'vagaSubmit']
)->name('cadastrar_vagaSubmit');

Route::get('/editar_vaga/{id}', [JobController::class, 'editar'])->name('editar_vaga');
Route::post('/editar_vaga/{id}', [JobController::class, 'editarSubmit'])->name('editar_vagaSubmit');

Route::delete('/deletar_vaga/{id}', [JobController::class, 'deletar'])->name('deletar_vaga');

Route::get('/', [JobController::class, 'home'])->name('home');


