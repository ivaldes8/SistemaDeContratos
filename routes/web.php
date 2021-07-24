<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\SearchController;

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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('dropdown',[DropdownController::class, 'index']);
Route::get('getGrupo',[DropdownController::class, 'getGrupo'])->name('getGrupo');
Route::get('getGrupoEntidad',[DropdownController::class, 'getGrupoEntidad'])->name('getGrupoEntidad');
Route::get('getClient',[DropdownController::class, 'getClient'])->name('getClient');
Route::get('getClientEntidad/{grupoID}/org/{organismoID}',[DropdownController::class, 'getClientEntidad'])->name('getClient');


Route::middleware(['auth','isAdmin'])->group(function () {
    Route::resource('user', 'UserController');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('organismos', 'OrganismoController');
    Route::resource('grupos', 'GrupoController');
    Route::resource('clientes_proveedores', 'ClienteProveedorController');
    Route::resource('contratos_marco', 'ContratoMarcoController');
    Route::resource('objeto_CM', 'ObjetoCMController');
    Route::resource('servicio_area','ServicioAreaController');
    Route::get('entidadSearch',[SearchController::class, 'entidadSearch']);
    Route::get('organismoSearch',[SearchController::class, 'organismoSearch']);
    Route::get('grupoSearch',[SearchController::class, 'grupoSearch']);
});

