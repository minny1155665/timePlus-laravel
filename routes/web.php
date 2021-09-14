<?php

use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Http\Controllers;
use App\Models\Event;
use App\Models\User;
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

// register RESTful Controllers
Route::resource('events', 'App\Http\Controllers\EventController');

// use EventControllers
Route::get('/favorite/{event}', 'App\Http\Controllers\EventController@favorite')->name('favorite');
Route::get('/cancelFav/{event}', 'App\Http\Controllers\EventController@cancelFav')->name('cancelFav');
Route::get('/attend/{event}', 'App\Http\Controllers\EventController@attend')->name('attend');
Route::get('/help/{event}', 'App\Http\Controllers\EventController@help')->name('help');
Route::get('/cancelAttend/{event}', 'App\Http\Controllers\EventController@cancelAttend')->name('cancelAttend');
Route::get('/attend', 'App\Http\Controllers\EventController@showAttend')->name('attend.show');
Route::get('/help', 'App\Http\Controllers\EventController@showHelp')->name('help.show');
Route::get('/end/{event}', 'App\Http\Controllers\EventController@endEvent')->name('end');

// use UserControllers
Route::get('/personal_page/{user}', 'App\Http\Controllers\UserController@show');
Route::get('/favorite_list', 'App\Http\Controllers\UserController@showFavorite');
Route::get('/hold_list', 'App\Http\Controllers\UserController@getHolds');
Route::get('/ticket_list', 'App\Http\Controllers\UserController@getTickets');

// use AuthController
Route::get('/auth/logout', 'App\Http\Controllers\AuthController@getLogout');

Route::get('/test/{event}', 'App\Http\Controllers\EventController@endEvent')->name('test');

Route::middleware(['auth:sanctum', 'verified'])->get('/', 'App\Http\Controllers\EventController@index');
