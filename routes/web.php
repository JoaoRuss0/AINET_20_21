<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StampController;
use App\Http\Controllers\UserController;
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

Route::get('/login', function () {
    return view('login')
        ->with("title","Login");
})->name('login');


/* Users */

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::post('/users/store', [UserController::class, 'store'])->name('users.store');


/* Stamps */

Route::get('/stamps', [StampController::class, 'index'])->name('stamps.index');

Route::get('/stamps/filter', [StampController::class, 'filter'])->name('stamps.filter');


/* Clientes */

Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');

Route::post('/clientes/store', [ClienteController::class, 'store'])->name('clientes.store');
