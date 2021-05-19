<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstampaController;
use App\Http\Controllers\ClienteController;

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
    return view('welcome')
        ->with("title","Welcome to MagicShirts!");
})->name('welcome');


/* Users */

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

Route::put('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');


/* Clientes */

Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

Route::post('/clientes/store', [ClienteController::class, 'store'])->name('clientes.store');

Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');

Route::put('/clientes/{cliente}/update', [ClienteController::class, 'update'])->name('clientes.update');


/* Stamps */

Route::get('/stamps', [EstampaController::class, 'index'])->name('stamps.index');

Route::get('/stamps/filter', [EstampaController::class, 'filter'])->name('stamps.filter');


/* Automatically created */

Auth::routes();
