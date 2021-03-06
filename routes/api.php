<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Lesson;

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

Route::get('/lesson-link/{lesson}', function (Lesson $lesson) {
    return $lesson->path();
});

/* @see PromoCodeController::index() */
Route::post('/promo-code', 'PromoCodeController@index');