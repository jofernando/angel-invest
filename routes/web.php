<?php

use App\Http\Controllers\PropostaController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\DocumentoController;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');

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

    Route::resource('startup/{startup}/propostas', PropostaController::class);
    Route::resource('startups/{startup}/enderecos', EnderecoController::class);
    Route::resource('startups/{startup}/documentos', DocumentoController::class);

    Route::get('/documentos/{documento}/arquivo', [DocumentoController::class, 'arquivo'])->name('documento.arquivo');
});
