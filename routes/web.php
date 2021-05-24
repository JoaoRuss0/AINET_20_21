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

/* Welcome */

Route::view('/', 'welcome', ['title' => "Welcome to MagicShirts!"])->name('welcome');


Route::middleware(['auth', 'verified'])->group(function()
{
    Route::name('users.')->prefix('users')->group(function()
    {
        Route::get('/', [UserController::class, 'index'])->name('index');

        Route::get('filter', [UserController::class, 'filter'])->name('filter');

        Route::get('create', [UserController::class, 'create'])->name('create');

        Route::post('/', [UserController::class, 'store'])->name('store');

        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');

        Route::put('{user}', [UserController::class, 'update'])->name('update');
    });


    Route::name('clientes.')->prefix('clientes')->group(function()
    {
        Route::get('{cliente}/edit', [ClienteController::class, 'edit'])->name('edit');

        Route::put('{cliente}', [ClienteController::class, 'update'])->name('update');
    });
});

Route::name('clientes.')->prefix('clientes')->group(function()
{
    Route::get('create', [ClienteController::class, 'create'])->name('create');

    Route::post('/', [ClienteController::class, 'store'])->name('store');
});

Route::name('estampas.')->prefix('estampas')->group(function()
{
    Route::get('/', [EstampaController::class, 'index'])->name('index');

    Route::get('filter', [EstampaController::class, 'filter'])->name('filter');
});


/* Auth */

// Exclude register because register = clientes.create
Auth::routes(['register' => false, 'verify' => true]);
