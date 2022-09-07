<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CMController;
use App\Http\Controllers\CPController;
use App\Http\Controllers\CPCUController;
use App\Http\Controllers\CuotaMercadoController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\EstadoCMController;
use App\Http\Controllers\EstadoCPController;
use App\Http\Controllers\EstadoCEController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\IndicadorProductoController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\NAEController;
use App\Http\Controllers\OrganismoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\ObjSupCMController;
use App\Http\Controllers\ObjSupCEController;
use App\Http\Controllers\ObjSupCPController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AreaServController;
use App\Http\Controllers\CEController;
use App\Http\Controllers\SupCMController;
use App\Http\Controllers\SupCEController;
use App\Http\Controllers\SupCPController;
use App\Http\Controllers\TipoCMController;
use App\Http\Controllers\TipoCPController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Mail;
use App\Http\Controllers\UserController;

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
});

Auth::routes();
Route::middleware(['auth'])->group(function () {

    Route::resource('organismo', OrganismoController::class);
    Route::get('organismo/delete/{id}', [OrganismoController::class, 'delete'])->name('delete');
    Route::get('organismo-file-export', [OrganismoController::class, 'export']);

    Route::resource('grupo', GrupoController::class);
    Route::get('GrupoByOrganismo', [GrupoController::class, 'getGrupoByOrganismo']);
    Route::get('ClienteByGrupo', [GrupoController::class, 'getClientByGrupo']);
    Route::get('ClienteByOrganismo', [GrupoController::class, 'getClientByOrganismo']);
    Route::get('ProveedorByGrupo', [GrupoController::class, 'getProviderByGrupo']);
    Route::get('ProveedorByOrganismo', [GrupoController::class, 'getProviderByOrganismo']);
    Route::get('grupo/delete/{id}', [GrupoController::class, 'delete'])->name('delete');
    Route::get('grupo-file-export', [GrupoController::class, 'export']);

    Route::resource('entidad', EntidadController::class);
    Route::get('cliente', [EntidadController::class, 'clientes']);
    Route::get('proveedor', [EntidadController::class, 'proveedores']);
});

Route::middleware(['auth', 'especialista'])->group(function () {
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('logs', [LogController::class, 'index']);
    Route::get('logs/delete', [LogController::class, 'delete'])->name('delete');
    Route::delete('logs', [LogController::class, 'destroy']);

    Route::resource('user', UserController::class);
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('delete');
});

Route::middleware(['auth', 'client'])->group(function () {

    Route::resource('tipocm', TipoCMController::class);
    Route::get('tipocm/delete/{id}', [TipoCMController::class, 'delete'])->name('delete');

    Route::resource('estadocm', EstadoCMController::class);
    Route::get('estadocm/delete/{id}', [EstadoCMController::class, 'delete'])->name('delete');

    Route::resource('objsupcm', ObjSupCMController::class);
    Route::get('objsupcm/delete/{id}', [ObjSupCMController::class, 'delete'])->name('delete');

    Route::resource('supcm', SupCMController::class);
    Route::get('supcm/create/{id}', [SupCMController::class, 'create']);
    Route::post('supcm/{id}', [SupCMController::class, 'store']);
    Route::get('supcm/delete/{id}', [SupCMController::class, 'delete'])->name('delete');

    Route::resource('ce', CEController::class);
    Route::get('ce/create/{id}', [CEController::class, 'create']);
    Route::post('ce/{id}', [CEController::class, 'store']);
    Route::get('ce/delete/{id}', [CEController::class, 'delete'])->name('delete');

    Route::resource('objsupce', ObjSupCEController::class);
    Route::get('objsupce/delete/{id}', [ObjSupCEController::class, 'delete'])->name('delete');

    Route::resource('supce', SupCEController::class);
    Route::get('supce/create/{id}', [SupCEController::class, 'create']);
    Route::post('supce/{id}', [SupCEController::class, 'store']);
    Route::get('supce/delete/{id}', [SupCEController::class, 'delete'])->name('delete');

    Route::resource('estadoce', EstadoCEController::class);
    Route::get('estadoce/delete/{id}', [EstadoCEController::class, 'delete'])->name('delete');

    Route::resource('areaserv', AreaServController::class);
    Route::post('areaserv/{id}', [AreaServController::class, 'store']);
    Route::get('servByArea', [AreaServController::class, 'getServicioByArea']);

    Route::resource('cm', CMController::class);
    Route::get('cm-export', [CMController::class, 'exportExcel']);
});

Route::middleware(['auth', 'provider'])->group(function () {

    Route::resource('tipocp', TipoCPController::class);
    Route::get('tipocp/delete/{id}', [TipoCPController::class, 'delete'])->name('delete');

    Route::resource('estadocp', EstadoCPController::class);
    Route::get('estadocp/delete/{id}', [EstadoCPController::class, 'delete'])->name('delete');

    Route::resource('objsupcp', ObjSupCPController::class);
    Route::get('objsupcp/delete/{id}', [ObjSupCPController::class, 'delete'])->name('delete');

    Route::resource('supcp', SupCPController::class);
    Route::get('supcp/create/{id}', [SupCPController::class, 'create']);
    Route::post('supcp/{id}', [SupCPController::class, 'store']);
    Route::get('supcp/delete/{id}', [SupCPController::class, 'delete'])->name('delete');

    Route::resource('cp', CPController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
