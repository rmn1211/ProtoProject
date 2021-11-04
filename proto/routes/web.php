<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\QueryController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/heafoo', [PageController::class, 'heafoo'])->name('heafoo');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/overview', [PageController::class, 'overview'])->name('overview');
Route::get('/overview/{id}', [PageController::class, 'report'])->name('report');
Route::post('/overview', [QueryController::class, 'updateMatch']);
Route::get('/match_ok', [PageController::class, 'match_ok'])->name('match_ok');
Route::get('/teams_overview', [PageController::class, 'teams_overview'])->name('teams_overview');
Route::get('/player_overview', [PageController::class, 'player_overview'])->name('player_overview');

//Neue OverviewRouten: Erstmal nur Test
Route::get('/overview/edit', [PageController::class, 'report'])->name('report');
Route::post('/overview/edit', [QueryController::class, 'updateMatch']);
Route::post('/overview/edit', [QueryController::class, 'updateSoloDuel']);
//ENDE TestRouten
Route::get('/autocomplete-search', [QueryController::class, 'autocompleteSearch']);

#Route::post('/overview/{id}', 'QueryController@updateOrt');
Route::get('/old', [PageController::class, 'old'])->name('old');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Queries
#Route::get('/overview/{id}', [QueryController::class, 'getResults'])->name('report');
Route::post('/alleLigen2', [QueryController::class, 'alleLigen2'])->name('alleLigen2');
Route::get('/alleLigen2', [QueryController::class, 'alleLigen2']);

Route::post('/alleMannschaften', [QueryController::class, 'alleMannschaften'])->name('alleMannschaften');
Route::get('/alleMannschaften', [QueryController::class, 'alleMannschaften']);
