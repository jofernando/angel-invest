<?php

use App\Http\Controllers\PropostaController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\LanceController;
use App\Http\Controllers\TelefoneController;
use App\Http\Controllers\LeilaoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'welcome'])->name('home');
Route::get('startup/{startup}/proposta/{proposta}', [PropostaController::class, 'show'])->name('propostas.show');
Route::get('/produtos', [PropostaController::class, 'search'])->name('produto.search');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('startups', StartupController::class);

    Route::get('/get-component', [StartupController::class, 'startupGetComponent'])->name('startup.component.ajax');

    Route::resource('startup/{startup}/propostas', PropostaController::class)->except('show');
    Route::resource('startups/{startup}/enderecos', EnderecoController::class);
    Route::resource('startups/{startup}/documentos', DocumentoController::class)->except('edit', 'update');
    Route::resource('leilao', LeilaoController::class)->except('show');
    Route::resource('leiloes.lances', LanceController::class)->parameters([
        'leiloes' => 'leilao'
    ])->except('index');
    Route::get('lances', [LanceController::class, 'index'])->name('lances');
    Route::get('leilao/{leilao}/termo', [LeilaoController::class, 'show_termo'])->name('leilao.termo');

    Route::get('startups/{startup}/documentos-edit', [DocumentoController::class, 'edit'])->name('documentos.edit');
    Route::put('startups/{startup}/documentos-update', [DocumentoController::class, 'update'])->name('documentos.update');

    Route::get('/documentos/{documento}/arquivo', [DocumentoController::class, 'arquivo'])->name('documento.arquivo');

    Route::resource('startups/{startup}/telefones', TelefoneController::class)->except('edit', 'update');
    Route::get('startups/{startup}/telefones-edit', [TelefoneController::class, 'edit'])->name('telefones.edit');
    Route::put('startups/{startup}/telefones-update', [TelefoneController::class, 'update'])->name('telefones.update');
});
