<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('notes', 'noteController@notes');
Route::get('notes/{id}', 'noteController@noteById');
Route::get('notes', 'noteController@searchByNote');

Route::post('notes', 'noteController@addNote');
Route::put('notes/{id}', 'noteController@editNote');
Route::delete('notes/{id}', 'noteController@deleteNote');
