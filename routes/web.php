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
Route::get('filterService/{cod}/serv/{serv}/area/{area}',[DropdownController::class, 'getServices'])->name('getServices');
Route::get('filterObj/{obj}',[DropdownController::class, 'getObjetos'])->name('getObjetos');
Route::get('filterObj2/{obj}',[DropdownController::class, 'getObjetos2'])->name('getObjetos2');

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
    Route::resource('contratos_especificos', 'ContratoEspecificoController');
    Route::get('contratos_especificos/create/{id}', 'ContratoEspecificoController@create');
    Route::resource('suplementoce', 'SuplementoCEController');
    Route::get('suplementoce/create/{id}', 'SuplementoCEController@create');
    Route::resource('suplementocm', 'SuplementoCMController');
    Route::get('suplementocm/create/{id}', 'SuplementoCMController@create');
    Route::resource('obj_sup_cm', 'ObjetoSupCMController');
    Route::resource('obj_sup_ce', 'ObjetoSupCEController');

    Route::get('entidadSearch',[SearchController::class, 'entidadSearch']);
    Route::get('organismoSearch',[SearchController::class, 'organismoSearch']);
    Route::get('grupoSearch',[SearchController::class, 'grupoSearch']);
    Route::get('servicioAreaSearch',[SearchController::class, 'servicioSearch']);
    Route::get('objetoCMSearch',[SearchController::class, 'objetoCMSearch']);
    Route::get('CMSearch',[SearchController::class, 'CMSearch']);
    Route::get('CESearch',[SearchController::class, 'CESearch']);
    Route::get('sup_cm_search',[SearchController::class, 'SupCMSearch']);
    Route::get('sup_ce_search',[SearchController::class, 'SupCESearch']);
    Route::get('obj_sub_cm_search',[SearchController::class, 'ObjSupCMSearch']);
    Route::get('obj_sub_ce_search',[SearchController::class, 'ObjSupCESearch']);
});

