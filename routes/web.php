<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CPCUController;
use App\Http\Controllers\CuotaMercadoController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\IndicadorProductoController;
use App\Http\Controllers\InformacionController;
use App\Http\Controllers\NAEController;
use App\Http\Controllers\OrganismoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SACLAPController;
use App\Http\Controllers\UnidadController;
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
Route::middleware(['auth','admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('delete');

    Route::resource('organismo', OrganismoController::class);
    Route::get('organismo/delete/{id}', [OrganismoController::class, 'delete'])->name('delete');
    Route::get('organismo-file-export', [OrganismoController::class, 'export']);

    Route::resource('grupo',GrupoController::class);
    Route::get('GrupoByOrganismo',[GrupoController::class, 'getGrupoByOrganismo']);
    Route::get('grupo/delete/{id}', [GrupoController::class, 'delete'])->name('delete');
    Route::get('grupo-file-export', [GrupoController::class, 'export']);

    Route::resource('entidad',EntidadController::class);

    // Route::resource('cpcu',CPCUController::class);
    // Route::get('cpcu/delete/{id}', [CPCUController::class, 'delete'])->name('delete');
    // Route::get('cpcu-file-import', [CPCUController::class, 'fileImportExport']);
    // Route::post('cpcu-file-import', [CPCUController::class, 'fileImport']);
    // Route::get('cpcu-file-export', [CPCUController::class, 'export']);

    // Route::resource('saclap',SACLAPController::class);
    // Route::get('saclap/delete/{id}', [SACLAPController::class, 'delete'])->name('delete');
    // Route::get('saclap-file-import', [SACLAPController::class, 'fileImportExport']);
    // Route::post('saclap-file-import', [SACLAPController::class, 'fileImport']);
    // Route::get('saclap-file-export', [SACLAPController::class, 'export']);

    // Route::resource('unidad',UnidadController::class);
    // Route::get('unidad/delete/{id}', [UnidadController::class, 'delete'])->name('delete');
    // Route::get('unidad-file-import', [UnidadController::class, 'fileImportExport']);
    // Route::post('unidad-file-import', [UnidadController::class, 'fileImport']);
    // Route::get('unidad-file-export', [UnidadController::class, 'export']);

    // Route::resource('producto',ProductoController::class);
    // Route::get('producto/delete/{id}', [ProductoController::class, 'delete'])->name('delete');
    // Route::get('filteringProd', [ProductoController::class, 'filter'])->name('producto-filtering');
    // Route::get('producto-file-import', [ProductoController::class, 'fileImportExport']);
    // Route::post('producto-file-import', [ProductoController::class, 'fileImport']);
    // Route::get('producto-file-export', [ProductoController::class, 'export']);

    // Route::resource('informacion',InformacionController::class);
    // Route::get('informacion/delete/{id}', [InformacionController::class, 'delete'])->name('delete');
    // Route::get('informacion-file-import', [InformacionController::class, 'fileImportExport']);
    // Route::post('informacion-file-import', [InformacionController::class, 'fileImport']);
    // Route::get('informacion-file-export', [InformacionController::class, 'export']);

    // Route::resource('actividad',ActividadController::class);
    // Route::get('actividad/delete/{id}', [ActividadController::class, 'delete'])->name('delete');
    // Route::get('actividad-file-import', [ActividadController::class, 'fileImportExport']);
    // Route::post('actividad-file-import', [ActividadController::class, 'fileImport']);
    // Route::get('actividad-file-export', [ActividadController::class, 'export']);

    // Route::resource('indicador',IndicadorController::class);
    // Route::get('indicador/delete/{id}', [IndicadorController::class, 'delete'])->name('delete');

    // Route::get('indicador-producto/create/{id}', [IndicadorProductoController::class, 'create'])->name('create');
    // Route::post('indicador-producto/create/{id}', [IndicadorProductoController::class, 'store'])->name('store');
    // Route::get('indicador-producto/{indicador}/edit/{producto}', [IndicadorProductoController::class, 'edit'])->name('edit');
    // Route::put('indicador-producto/{indicador}/update/{producto}', [IndicadorProductoController::class, 'update'])->name('update');
    // Route::get('indicador-producto/delete/{id}', [IndicadorProductoController::class, 'delete'])->name('delete');
    // Route::delete('indicador-producto/delete/{id}', [IndicadorProductoController::class, 'destroy'])->name('destroy');

    // Route::get('cuotaDeMercado', [ReportesController::class, 'cuotaDeMercado'])->name('cuotaDeMercado');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

