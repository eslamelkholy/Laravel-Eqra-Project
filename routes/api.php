
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Http\Controllers\AccessTokenController;

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


// Authentication & User Api's
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

// Normal Api's >> Tokens & application/json Must Be Included to work
// Route::group(['middleware' => 'auth:api'], function () {
Route::apiResource("post", 'PostController');
Route::get("post/{post}/likes", 'LikesController@plikes');
Route::get("comment/{comment}/likes", 'LikesController@clikes');
// });


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("comment", 'CommentController');
});
