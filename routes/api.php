<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiToken;
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

Route::get('/user', 'UserController@getList')->name('home');

Route::group(['middleware' => ApiToken::class], function () {
    Route::post('post', 'PostController@store')->name('post:post:store');
    Route::get('post', 'PostController@getList')->name('get:post:list');
});
