<?php

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


Route::get('/', function () {return view('home');});

Route::get('/soccertables', 'App\Http\Controllers\LeagueController@home');
Route::get('matches/{league}','App\Http\Controllers\LeagueController@showLatest');
Route::get('matches/{league}/{date}', 'App\Http\Controllers\LeagueController@showDate');


Route::get('soccertables/about', function() 
{
	return View::make('soccertables/about');
});

Route::post('leaguetable/{league}/{date}', 'App\Http\Controllers\LeagueController@showLeagueTable');
Route::post('formtable/{league}/{date}', 'App\Http\Controllers\LeagueController@showFormTable');

Route::post('cookie-accept', function() 
{
	if(Request::ajax())
	{
		$cookie = Cookie::get('soccer-tables');
		if($cookie) $cookie = json_decode($cookie,true);
		else $cookie = array();
		$cookie['closed'] = true;
		$cookie = Cookie::forever('soccer-tables', json_encode($cookie));
		return Response::make('')->withCookie($cookie);
	}
});

Route::get('draganddrop', function()
{
	return View::make('draganddrop/home');
});

//Contact Page
Route::get('contact', 'App\Http\Controllers\ContactController@getContact');
Route::post('contact_request','App\Http\Controllers\ContactController@getContactUsForm');
