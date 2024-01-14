<?php

use App\Http\Controllers\ExportController;
use App\Http\Livewire\AsignController;
use App\Http\Livewire\CashoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\ProductController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\ReportController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\UserController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('categories', CategoriesController::class);
Route::get('products', ProductController::class);
Route::get('coins', CoinsController::class);
Route::get('pos', PosController::class);
Route::get('roles', RolesController::class);
Route::get('permisos', PermisosController::class);
Route::get('asignar', AsignController::class);
Route::get('usuarios', UserController::class);
Route::get('arqueos', CashoutController::class);
Route::get('reportes', ReportController::class);

//Reportes PDF
Route::get('report/pdf/{userId}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
Route::get('report/pdf/{userId}/{type}', [ExportController::class, 'reportPDF']);

//Reportes Excel
Route::get('report/excel/{userId}/{type}/{f1}/{f2}', [ExportController::class, 'reportExcel']);
Route::get('report/excel/{userId}/{type}', [ExportController::class, 'reportExcel']);




