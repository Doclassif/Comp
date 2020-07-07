<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('users','UserController');

// Route::get('/', 'DBController@view');
// Route::post('/DBedit', 'DBController@update');
// Route::post('/DBinsert', 'DBController@insert');
Route::post('/fileUpd', 'DBController@fileupd');
// Route::post('/draganddrop', 'DBController@draganddrop');

Route::post('/login', 'Auth\AuthController@Login');

Route::middleware('auth:api')->group(function () {
    Route::post('/g', 'Auth\AuthController@get1');
   Route::post('/logout', 'Auth\AuthController@Logout');
   Route::get('/get-user', 'Auth\AuthController@getUser');
});


/*Route::get('/', function () {
    return "test";
});*/

