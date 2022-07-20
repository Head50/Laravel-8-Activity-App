<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;

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

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::post('/profile', [UserController::class, 'profile']);
    Route::post('/SelfDelete', [UserController::class, 'delete']);
});

Route::group(['middleware' => ['api', 'jwt.verify'], 'prefix' => 'activity'], function($router) {
    Route::post('/create', [ActivityController::class, 'create']);
    Route::get('', [ActivityController::class, 'allActivity']);
    Route::post('/update', [ActivityController::class, 'update']);
    Route::post('/delete', [ActivityController::class, 'delete']);
});
