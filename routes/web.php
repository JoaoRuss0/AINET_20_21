<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrecoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstampaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EncomendaController;

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


Route::middleware(['auth', 'bloqueado', 'verified'])->group(function()
{
    Route::name('users.')->prefix('users')->group(function()
    {
        Route::get('/',                 [UserController::class, 'index'])           ->name('index')         ->middleware('can:viewAny,App\Models\User');

        Route::get('{user}/show',       [UserController::class, 'show'])            ->name('show')          ->middleware('can:view,user');

        Route::get('filter',            [UserController::class, 'filter'])          ->name('filter')        ->middleware('can:viewAny,App\Models\User');

        Route::get('create',            [UserController::class, 'create'])          ->name('create')        ->middleware('can:create,App\Models\User');

        Route::post('/',                [UserController::class, 'store'])           ->name('store')         ->middleware('can:create,App\Models\User');

        Route::get('{user}/edit',       [UserController::class, 'edit'])            ->name('edit')          ->middleware('can:update,user');

        Route::put('{user}',            [UserController::class, 'update'])          ->name('update')        ->middleware('can:update,user');

        Route::put('{user}/block',      [UserController::class, 'alterBlocked'])    ->name('block')         ->middleware('can:block_destroy_type,user');

        Route::delete('{user}',         [UserController::class, 'destroy'])         ->name('destroy')       ->middleware('can:block_destroy_type,user');
    });

    Route::name('clientes.')->prefix('clientes')->group(function()
    {
        Route::get('{cliente}/show',    [ClienteController::class, 'show'])         ->name('show')          ->middleware('can:view,cliente');

        Route::get('{cliente}/edit',    [ClienteController::class, 'edit'])         ->name('edit')          ->middleware('can:update,cliente');

        Route::put('{cliente}',         [ClienteController::class, 'update'])       ->name('update')        ->middleware('can:update,cliente');
    });

    Route::name('estampas.')->prefix('estampas')->group(function()
    {
        Route::get('create',            [EstampaController::class, 'create'])       ->name('create')        ->middleware('can:create,App\Models\Estampa');

        Route::post('/',                [EstampaController::class, 'store'])        ->name('store')         ->middleware('can:create,App\Models\Estampa');

        Route::get('{estampa}/edit',    [EstampaController::class, 'edit'])         ->name('edit')          ->middleware('can:update,estampa');

        Route::put('{estampa}',         [EstampaController::class, 'update'])       ->name('update')        ->middleware('can:update,estampa');

        Route::delete('{estampa}',      [EstampaController::class, 'destroy'])      ->name('destroy')       ->middleware('can:delete,estampa');
    });

    Route::name('categorias.')->prefix('categorias')->group(function()
    {
        Route::get('/',                 [CategoriaController::class, 'index'])      ->name('index')         ->middleware('can:viewAny,App\Models\Categoria');

        Route::post('/',                [CategoriaController::class, 'store'])      ->name('store')         ->middleware('can:create,App\Models\Categoria');

        Route::put('{categoria}',       [CategoriaController::class, 'update'])     ->name('update')        ->middleware('can:update,categoria');

        Route::delete('{categoria}',    [CategoriaController::class, 'destroy'])    ->name('destroy')       ->middleware('can:delete,categoria');
    });

    Route::name('cores.')->prefix('cores')->group(function()
    {
        Route::get('/',                 [CorController::class, 'index'])            ->name('index')         ->middleware('can:viewAny,App\Models\Cor');

        Route::post('/',                [CorController::class, 'store'])            ->name('store')         ->middleware('can:create,App\Models\Cor');

        Route::get('{cor}/edit',        [CorController::class, 'edit'])             ->name('edit')          ->middleware('can:update,cor');

        Route::put('{cor}',             [CorController::class, 'update'])           ->name('update')        ->middleware('can:update,cor');

        Route::delete('{cor}',          [CorController::class, 'destroy'])          ->name('destroy')       ->middleware('can:delete,cor');
    });

    Route::name('precos.')->prefix('precos')->group(function()
    {
        Route::put('{preco}',           [PrecoController::class, 'update'])         ->name('update')        ->middleware('can:update,preco');
    });

    Route::name('estampas.')->prefix('estampas')->group(function()
    {
        Route::get('/',                 [EstampaController::class, 'index'])        ->name('index');

        Route::get('{estampa}/show',    [EstampaController::class, 'show'])         ->name('show');

        Route::get('filter',            [EstampaController::class, 'filter'])       ->name('filter');
    });

    Route::name('precos.')->prefix('precos')->group(function()
    {
        Route::get('/',                 [PrecoController::class, 'index'])          ->name('index');
    });

    Route::name('cart.')->prefix('cart')->group(function()
    {
        Route::get('/',                 [CartController::class, 'index'])           ->name('index')         ->middleware('can:view,App\Models\Cart');
    });

    Route::name('encomendas.')->prefix('encomendas')->group(function()
    {
        Route::get('/',                 [EncomendaController::class, 'index'])     ->name('index');

        Route::get('{encomenda}/show',  [EncomendaController::class, 'show'])       ->name('show')          ->middleware('can:view,encomenda');;

        Route::post('/',                [EncomendaController::class, 'store'])     ->name('store')          ->middleware('can:create,App\Models\Encomenda');
    });
});

Route::middleware(['guest'])->group(function()
{
    Route::name('clientes.')->prefix('clientes')->group(function()
    {
        Route::get('create',            [ClienteController::class, 'create'])       ->name('create');

        Route::post('/',                [ClienteController::class, 'store'])        ->name('store');
    });

    Route::name('estampas.guest.')->prefix('estampas/guest')->group(function()
    {
        Route::get('/',            [EstampaController::class, 'index'])             ->name('index');

        Route::get('{estampa}/show',    [EstampaController::class, 'show'])         ->name('show');

        Route::get('filter',            [EstampaController::class, 'filter'])       ->name('filter');
    });

    Route::name('precos.')->prefix('precos')->group(function()
    {
        Route::get('/guest',            [PrecoController::class, 'index'])          ->name('guest.index');
    });

    Route::name('cart.')->prefix('cart')->group(function()
    {
        Route::get('/guest',                [CartController::class, 'index'])           ->name('guest.index')   ->middleware('can:view,App\Models\Cart');
    });
});


Route::name('cart.')->prefix('cart')->group(function()
{

    Route::get('{estampa}/add',         [CartController::class, 'addView'])         ->name('add')           ->middleware('can:update,App\Models\Cart');

    Route::post('/',                    [CartController::class, 'addToCart'])       ->name('store')         ->middleware('can:update,App\Models\Cart');

    Route::put('{id}',                  [CartController::class, 'update'])          ->name('update')        ->middleware('can:update,App\Models\Cart');

    Route::delete('{id}',               [CartController::class, 'update'])          ->name('remove')        ->middleware('can:update,App\Models\Cart');

    Route::delete('/',                  [CartController::class, 'destroy'])         ->name('destroy')       ->middleware('can:delete,App\Models\Cart');
});

/* Auth */

// Exclude register because register = clientes.create
Auth::routes(['register' => false, 'verify' => true]);
