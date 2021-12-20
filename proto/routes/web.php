<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\QueryController;
use Illuminate\Support\Facades\Route;

  

use App\Http\Controllers\ImageUploadController;

  

  

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
Route::get('/match_ok/{id}', [PageController::class, 'view'])->name('view');
Route::get('/upload', [PageController::class, 'upload'])->name('upload');
Route::post('/upload', [QueryController::class, 'insertMatch']);
Route::get('/player_overview', [PageController::class, 'player_overview'])->name('player_overview');
Route::get('/make_report', [PageController::class, 'make'])->name('make');
//Neue OverviewRouten: Erstmal nur Test
Route::get('/overview/edit', [PageController::class, 'report'])->name('report');
Route::post('/overview/edit', [QueryController::class, 'updateMatch']);
Route::post('/overview/edit', [QueryController::class, 'updateSoloDuel']);
Route::get('/overviews/player_table', [PageController::class, 'player_table'])->name('player_table');
Route::get('/overviews/teams_table', [PageController::class, 'teams_table'])->name('teams_table');
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
Route::post('/alleRegionen', [QueryController::class, 'alleRegionen'])->name('alleRegionen');
Route::get('/alleRegionen', [QueryController::class, 'alleRegionen']);
Route::post('/regionLigen', [QueryController::class, 'regionLigen'])->name('regionLigen');
Route::get('/regionLigen', [QueryController::class, 'regionLigen']);
Route::post('/mannschaften', [QueryController::class, 'mannschaften'])->name('mannschaften');
Route::get('/mannschaften', [QueryController::class, 'mannschaften']);
Route::post('/regionMannschaften', [QueryController::class, 'regionMannschaften'])->name('regionMannschaften');
Route::get('/regionMannschaften', [QueryController::class, 'regionMannschaften']);
Route::post('/alleMannschaften', [QueryController::class, 'alleMannschaften'])->name('alleMannschaften');
Route::get('/alleMannschaften', [QueryController::class, 'alleMannschaften']);
Route::post('/getSpielerVname', [QueryController::class, 'getSpielerVname'])->name('getSpielerVname');
Route::get('/getSpielerVname', [QueryController::class, 'getSpielerVname']);
Route::post('/getSpielerNname', [QueryController::class, 'getSpielerNname'])->name('getSpielerNname');
Route::get('/getSpielerNname', [QueryController::class, 'getSpielerNname']);
Route::post('/saison', [QueryController::class, 'saison'])->name('saison');
Route::get('/saison', [QueryController::class, 'saison']);
  Route::post('/runde', [QueryController::class, 'runde'])->name('runde');
Route::get('/runde', [QueryController::class, 'runde']);
  Route::post('/tag', [QueryController::class, 'tag'])->name('tag');
Route::get('/tag', [QueryController::class, 'tag']);
Route::get('image-upload', [ ImageUploadController::class, 'imageUpload' ])->name('image.upload');

Route::post('image-upload', [ ImageUploadController::class, 'imageUploadPost' ])->name('image.upload.post');

