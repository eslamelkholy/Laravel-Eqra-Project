
<?php

use App\Http\Controllers\MessageController;
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
        Route::patch('users/{id}/edit', 'AuthController@update');
    });
});

// Normal Api's >> Tokens & application/json Must Be Included to work
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("post", 'PostController');
    Route::get("post/{post}/likes", 'LikesController@plikes');
    Route::post("post/like", 'LikesController@pStore');
    Route::delete("post/{post}/likes/{user}", 'LikesController@pDestroy');
    Route::get("comment/{comment}/likes", 'LikesController@clikes');
    Route::post("comment/like", 'LikesController@cStore');
    Route::delete("comment/{comment}/likes/{user}", 'LikesController@cdestroy');
    // Genres Section
    Route::apiResource("user/genre", 'UserGenreController');
    Route::apiResource("genre", 'GenreController');
    // Events Section
    Route::apiResource("event", 'EventController')->middleware("WriterMiddleware");
    Route::post("event/{event}/participants", 'EventParticipantController@addParticipant');
    Route::post("event/{event}/participantStatus", 'EventParticipantController@ParticipantStatus');

});


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("comment", 'CommentController');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("follow", 'FollowController');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("chat", 'ChatController');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/private-messages/{reciever}',"MessageController@privateMessages")->name("privateMessages");
    Route::post('/private-messages',"MessageController@sendPrivateMessage")->name("privateMessages.store");
});
