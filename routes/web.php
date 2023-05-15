<?php

use App\Http\Controllers\BatimentController;
use App\Http\Controllers\CategoriedepenseController;
use App\Http\Controllers\Entree\ConstatoeufController;
use App\Http\Controllers\Entree\ConstatpouletController;
use App\Http\Controllers\Entree\CycleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Sortie\PrixpouletController;
use App\Http\Controllers\Sortie\SortiepouletController;
use App\Http\Controllers\TypedepenseController;
use App\Http\Controllers\TypeoeufController;
use App\Http\Controllers\TypepouletController;
use App\Http\Controllers\TypesortieController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

Route::group(['prefix' => 'parametrages', 'middleware' => 'auth'], function(){
    Route::get('site', [SiteController::class, 'page'])->name('parametrages.site');
    Route::get('batiment', [BatimentController::class, 'page'])->name('parametrages.batiments');
    Route::get('type_poulet', [TypepouletController::class, 'page'])->name('parametrages.type_poulets');
    Route::get('type_oeuf', [TypeoeufController::class, 'page'])->name('parametrages.type_oeufs');
    Route::get('categorie_depense', [CategoriedepenseController::class, 'page'])->name('parametrages.categorie_depenses');
    Route::get('type_depense', [TypedepenseController::class, 'page'])->name('parametrages.type_depenses');
    Route::get('type_sortie', [TypesortieController::class, 'page'])->name('parametrages.type_sorties');
});

Route::group(['prefix' => 'gestion_entree', 'middleware' => 'auth'], function(){
    Route::get('cycle', [CycleController::class, 'page'])->name('gestion_entree.cycles');
    Route::get('constat_oeuf', [ConstatoeufController::class, 'page'])->name('gestion_entree.constat_oeufs');
    Route::get('donnee_du_jour_constat_oeuf', [ConstatoeufController::class, 'donneeJournalierConstat'])->name('gestion_entree.donnee_du_jour_constat_oeuf');
    Route::get('constat_poulet', [ConstatpouletController::class, 'page'])->name('gestion_entree.constat_poulets');
});

Route::group(['prefix' => 'gestion_sortie', 'middleware' => 'auth'], function(){
    Route::get('sortie_poulet', [SortiepouletController::class, 'page'])->name('gestion_sortie.sortie_poulets');
    Route::get('prix_poulet',[PrixpouletController::class, 'page'])->name('gestion_sortie.prix_poulets');
});