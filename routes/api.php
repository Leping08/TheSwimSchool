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

Route::post('/athlete/new', 'SwimTeam\AthleteController@new')->name('api.athlete.update');

Route::post('/athlete/{hash}', 'SwimTeam\AthleteController@update')->name('api.athlete.update');

Route::post('/stripe-token/payment-intent', 'StripePaymentIntentController@store');

Route::post('/promo-code', 'PromoCodeController@index');