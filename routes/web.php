<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('home', HomeController::class);

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('equipos', EquipoController::class);

/*Route::get('/vue', function(){
    return view('vue');
})->name('vue');*/

Route::group(['prefix' => 'reporte'], function () {
    Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/search', [ReporteController::class, 'search'])->name('reportes.search');
    Route::get('/downloadpdf', [ReporteController::class, 'downloadPdf'])->name('reportes.pdf');
    Route::get('/vueReport', [ReporteController::class, 'getRecords'])->name('reportes.vue');
});


