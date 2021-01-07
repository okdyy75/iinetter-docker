<?php

use App\Http\Controllers\API\V1\LoginUser\ApiTokenController as LoginUserApiTokenController;
use App\Http\Controllers\API\V1\LoginUser\UserAPIController as LoginUserUserAPIController;
use App\Http\Controllers\API\V1\LoginUser\UserProfileAPIController as LoginUserUserProfileAPIController;
use App\Http\Controllers\API\V1\LoginUser\TweetAPIController as LoginUserTweetAPIController;
use App\Http\Controllers\API\V1\LoginController;
use App\Http\Controllers\API\V1\RegisterController;
use App\Http\Controllers\API\V1\UserAPIController;
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

Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::put('api_token', [LoginUserApiTokenController::class, 'update']);
        Route::get('user', [LoginUserUserAPIController::class, 'index']);
        Route::patch('user', [LoginUserUserAPIController::class, 'update']);
        Route::delete('user', [LoginUserUserAPIController::class, 'destroy']);

        Route::get('user_profile', [LoginUserUserProfileAPIController::class, 'index']);
        Route::post('user_profile', [LoginUserUserProfileAPIController::class, 'store']);

        Route::get('tweets', [LoginUserTweetAPIController::class, 'index']);
        Route::post('tweets', [LoginUserTweetAPIController::class, 'store']);
        Route::patch('tweets/{id}', [LoginUserTweetAPIController::class, 'update']);
        Route::delete('tweets/{id}', [LoginUserTweetAPIController::class, 'destroy']);
    });

    Route::get('users', [UserAPIController::class, 'index']);
    Route::get('users/{name}', [UserAPIController::class, 'show']);
});
