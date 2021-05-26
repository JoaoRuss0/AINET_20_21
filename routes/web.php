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

Route::view('/', 'welcome', ['title' => "Welcome to MagicShirts!"])                 ->name('welcome');


Route::middleware(['auth', 'verified'])->group(function()
{
    Route::name('users.')->prefix('users')->group(function()
    {
        Route::get('/',                 [UserController::class, 'index'])           ->name('index')     ->middleware('can:viewAny,App\Models\User');

        Route::get('{user}/show',       [UserController::class, 'show'])            ->name('show')      ->middleware('can:view,user');

        Route::get('filter',            [UserController::class, 'filter'])          ->name('filter')    ->middleware('can:viewAny,App\Models\User');

        Route::get('create',            [UserController::class, 'create'])          ->name('create')    ->middleware('can:create,App\Models\User');

        Route::post('/',                [UserController::class, 'store'])           ->name('store')     ->middleware('can:create,App\Models\User');

        Route::get('{user}/edit',       [UserController::class, 'edit'])            ->name('edit')      ->middleware('can:update,user');

        Route::put('{user}',            [UserController::class, 'update'])          ->name('update')    ->middleware('can:update,user');

        Route::put('{user}/block',      [UserController::class, 'alterBlocked'])    ->name('block')     ->middleware('can:block_destroy_type,user');

        Route::put('{user}/destroy',    [UserController::class, 'destroy'])         ->name('destroy')   ->middleware('can:block_destroy_type,user');
    });


    Route::name('clientes.')->prefix('clientes')->group(function()
    {
        Route::get('{cliente}/show',    [ClienteController::class, 'show'])         ->name('show')->middleware('can:view,cliente');

        Route::get('{cliente}/edit',    [ClienteController::class, 'edit'])         ->name('edit')->middleware('can:update,cliente');

        Route::put('{cliente}',         [ClienteController::class, 'update'])       ->name('update')->middleware('can:update,cliente');
    });
});

Route::middleware(['guest'])->name('clientes.')->prefix('clientes')->group(function()
{
    Route::get('create',                [ClienteController::class, 'create'])       ->name('create');

    Route::post('/',                    [ClienteController::class, 'store'])        ->name('store');
});

Route::name('estampas.')->prefix('estampas')->group(function()
{
    Route::get('/',                     [EstampaController::class, 'index'])        ->name('index');

    Route::get('filter',                [EstampaController::class, 'filter'])       ->name('filter');
});


/* Auth */

// Exclude register because register = clientes.create
Auth::routes(['register' => false, 'verify' => true]);
