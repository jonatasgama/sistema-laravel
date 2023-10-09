<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteEmail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('tarefa/exportacao/{formato}', [\App\Http\Controllers\TarefaController::class, 'exportacao'])->name('tarefa.exportacao');
//estou comentando a rota home, pois defini outra rota como default no RouteServiceProvider
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::resource('tarefa', TarefaController::class)->middleware('verified');
Route::get("/mail", function(){
    return new MensagemTesteEmail;
});