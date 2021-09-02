<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QueryController;


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
Route::post('/overview/{id}',[QueryController::class, 'updateMatch']);
Route::get('/autocomplete-search', [QueryController::class, 'autocompleteSearch']);

#Route::post('/overview/{id}', 'QueryController@updateOrt');
Route::get('/old', [PageController::class, 'old'])->name('old');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Queries
#Route::get('/overview/{id}', [QueryController::class, 'getResults'])->name('report');

Route::post('/alleLigen2', [QueryController::class, 'alleLigen2'])->name('alleLigen2');
Route::get('/alleLigen2', [QueryController::class, 'alleLigen2']);

//Route::get('/report/check_report', [QueryController::class, 'index']); 
