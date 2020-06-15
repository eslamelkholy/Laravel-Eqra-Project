
<?php

use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Http\Controllers\AccessTokenController;

// Authentication & User Api's
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('getuser/{id}', 'AuthController@getSpecificUser');
        Route::put('users/edit', 'AuthController@update');
    });
});

// Normal Api's >> Tokens & application/json Must Be Included to work
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("post", 'PostController');
    Route::get("userposts/{userId}", 'AuthController@currentUsrPosts');
    Route::get("userFeaturedPosts/{userId}", 'AuthController@currentUsrFeaturedPosts');
    Route::get("post/{post}/likes", 'LikesController@plikes');
    Route::post("post/like", 'LikesController@pStore');
    Route::delete("post/{post}/likes/{user}", 'LikesController@pDestroy');
    Route::get("post/{post}/likes/{user}", 'LikesController@checkForPlike');
    Route::get("comment/{comment}/likes", 'LikesController@clikes');
    Route::post("comment/like", 'LikesController@cStore');
    Route::delete("comment/{comment}/likes/{user}", 'LikesController@cdestroy');
    Route::get("comment/{comment}/likes/{user}", 'LikesController@checkForClike');
    // Genres Section
    Route::apiResource("user/genre", 'UserGenreController');
    Route::apiResource("genre", 'GenreController');
    // Events Section
    Route::apiResource("event", 'EventController');
    Route::post("event/{event}/participants", 'EventParticipantController@addParticipant');
    Route::post("event/{event}/participantStatus", 'EventParticipantController@changeParticipantStatus');
    Route::get("event/{event}/participantStatus", 'EventParticipantController@getUserEventStatus');
    Route::get("user/event", 'EventParticipantController@getUserEvents');
    // Events Posts Section
    Route::get("event/{event}/posts", 'EventPostController@getEventPosts');
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("comment", 'CommentController');
});



Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("chat", 'ChatController');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/private-messages/{recieverid}', "MessageController@privateMessages")->name("privateMessages");
    Route::post('/private-messages', "MessageController@sendPrivateMessage")->name("privateMessages.store");
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/my-followers', "FollowController@getMyFollowers");
    Route::get('/persons-i-follow', "FollowController@getPersonsIFollow");
    Route::post('/follow/{id}', "FollowController@follow");
    Route::delete('/unfollow/{id}', "FollowController@unfollow");
    Route::get('/followersCount', "FollowController@getFollowersCount");
});

//elastic search trends route
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/trends', "ElasticController@trends");
    Route::get('/trends/{name}', "ElasticController@getWriterPosts");
});
