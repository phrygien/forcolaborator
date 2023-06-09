<?php

use App\Http\Controllers\BatimentController;
use App\Http\Controllers\CategoriedepenseController;
use App\Http\Controllers\Depense\DepenseglobalContoller;
use App\Http\Controllers\Depense\ListedepenseController;
use App\Http\Controllers\Depense\UniteController;
use App\Http\Controllers\Depense\UtilisationdepenseController;
use App\Http\Controllers\Entree\ConstatoeufController;
use App\Http\Controllers\Entree\ConstatpouletController;
use App\Http\Controllers\Entree\CycleController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibelledepenseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Sortie\ClientController;
use App\Http\Controllers\Sortie\PrixoeufController;
use App\Http\Controllers\Sortie\PrixpouletController;
use App\Http\Controllers\Sortie\SortieoeufController;
use App\Http\Controllers\Sortie\SortiepouletController;
use App\Http\Controllers\TypedepenseController;
use App\Http\Controllers\TypeoeufController;
use App\Http\Controllers\TypepouletController;
use App\Http\Controllers\TypesortieController;

Route::get('/', function () {
    return view('auth.login');
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
    Route::get('libelle_depense', [LibelledepenseController::class, 'page'])->name('parametrages.libelle_depense');
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
    Route::get('sortie_oeuf', [SortieoeufController::class, 'page'])->name('gestion_sortie.sortie_oeufs');
    Route::get('sortie_oeuf2', [SortieoeufController::class, 'page2'])->name('gestion_sortie.sortie_oeufs2');
    Route::get('prix_oeuf', [PrixoeufController::class, 'page'])->name('gestion_sortie.prix_oeufs');
});

Route::group(['prefix' => 'gestion', 'middleware' => 'auth'], function(){
    Route::get('client', [ClientController::class, 'page'])->name('gestion.clients');
});

Route::group(['prefix' => 'gestion_depense', 'middleware' => 'auth'], function(){
    Route::get('depense_globale', [DepenseglobalContoller::class, 'page'])->name('gestion_depense.depense_globales');
    Route::get('utilisation_depense', [UtilisationdepenseController::class, 'page'])->name('gestion_depense.utilisation_depenses');
    Route::get('unite', [UniteController::class, 'page'])->name('gestion_depense.unites');
    Route::get('liste_depense', [ListedepenseController::class, 'page'])->name('gestion_depense.liste_depenses');
});