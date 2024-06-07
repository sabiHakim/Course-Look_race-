<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('verif',[\App\Http\Controllers\LoginController::class,'verif']);
Route::get('/', function () {
    return view('Login.Profilequipe');
});
Route::get('admin',function (){
    $admin = \App\Models\Login::all();
    return view('Login.login',compact('admin'));
});
Route::get('init',[\App\Http\Controllers\LoginController::class,'init']);

Route::post('traitLogin',[\App\Http\Controllers\LoginController::class,'traitLogin'])->name('traitLogin');
Route::middleware('securityAdmin')->group(function (){
Route::get('logout',[\App\Http\Controllers\LoginController::class,'logout']);
Route::get('acceuil',[\App\Http\Controllers\LoginController::class,'acceuil']);
Route::get('AffectationHeure/{id}',[\App\Http\Controllers\LoginController::class,'AffectationHeure']);
Route::get('traitAffHeurre',[\App\Http\Controllers\LoginController::class,'traitAffHeurre']);
Route::get('classementAdmin',[\App\Http\Controllers\LoginController::class,'classementAdmin']);
Route::get('classementEquipeAdmin',[\App\Http\Controllers\LoginController::class,'classementEquipeAdmin']);
Route::get('classementAdmin_chaque_etape/{id}',[\App\Http\Controllers\LoginController::class,'classementAdmin_chaque_etape']);
Route::get('affiche_cat',[\App\Http\Controllers\importController::class,'affiche_cat']);
Route::get('pdf',[\App\Http\Controllers\importController::class,'pdf']);
Route::get('importER',[\App\Http\Controllers\importController::class,'importER']);
Route::get('importERP',[\App\Http\Controllers\importController::class,'importERP']);
Route::post('/etp',[\App\Http\Controllers\importController::class,'etp'])->name('etp');
Route::post('/pts',[\App\Http\Controllers\importController::class,'pts'])->name('pts');
Route::get('/genererCat',[\App\Http\Controllers\importController::class,'genererCat']);
Route::get('/Penalites',[\App\Http\Controllers\PenaliteController::class,'Penalites']);
Route::get('deleteF',[\App\Http\Controllers\PenaliteController::class,'deleteF']);
Route::get('/addPenalites',[\App\Http\Controllers\PenaliteController::class,'addPenalites']);
Route::get('/traiAddPenaliter',[\App\Http\Controllers\PenaliteController::class,'traiAddPenaliter']);
});

Route::get('profilEquipe',[\App\Http\Controllers\EquipeController::class,'profilEquipe']);
Route::post('traitLoginEquipe',[\App\Http\Controllers\EquipeController::class,'traitLoginEquipe']);
Route::middleware('securityequipe')->group(function (){
    Route::get('logoutequipe',[\App\Http\Controllers\EquipeController::class,'logoutequipe']);
    Route::get('accequipe',[\App\Http\Controllers\EquipeController::class,'accequipe']);
    Route::get('affectation/{id}',[\App\Http\Controllers\EquipeController::class,'affectation']);
    Route::get('traitAffect',[\App\Http\Controllers\EquipeController::class,'traitAffect']);
    Route::get('classement',[\App\Http\Controllers\EquipeController::class,'classement']);
    Route::get('classementEquipe',[\App\Http\Controllers\EquipeController::class,'classementEquipe']);
});

