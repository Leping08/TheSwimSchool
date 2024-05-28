<?php

use App\Lesson;
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

Route::get('/lesson-link/{lesson}', function (Lesson $lesson) {
    return $lesson->path();
});

// todo deprecate soon
// these were the routes for the old swimmer registration form
Route::post('/swim-team/swimmer', [\App\Http\Controllers\SwimTeam\SwimmerController::class, 'update'])->name('api.swimmer.update');
Route::post('/swim-team/swimmer/promo-code', [\App\Http\Controllers\SwimTeam\SwimmerController::class, 'savePromoCode'])->name('api.swimmer.promo-code.update');
Route::post('/stripe-token/payment-intent/swimmer', [\App\Http\Controllers\StripePaymentIntentController::class, 'store']);

// Used to update the athlete data in the DB when signing up for the swim team
Route::post('/athlete/{hash}', [\App\Http\Controllers\SwimTeam\AthleteController::class, 'update'])->name('api.athlete.update');

// Used when signing up an athlete and the promo code is for free.
// It will create the swimmer and send out the email but no payment is needed.
Route::post('/swim-team/athlete/promo-code', [\App\Http\Controllers\SwimTeam\SwimmerController::class, 'save'])->name('api.athlete.promo-code.update');

// Used when signing up an athlete without a free promo code.
// It will charge the card through the payment intent and create the swimmer and send out the email.
Route::post('/stripe-token/payment-intent/athlete', [\App\Http\Controllers\StripePaymentIntentController::class, 'createForAthlete'])->name('api.athlete.payment-intent');

// Used to get the discount percentage for a promo code
Route::post('/promo-code', [\App\Http\Controllers\PromoCodeController::class, 'index'])->name('api.promo-code.index');

// Update the attendance for the pool session
Route::post('/pool-session-attendance/{poolSessionAttendanceId}', [\App\Http\Controllers\PoolSessionAttendanceController::class, 'update'])->name('api.pool-session-attendance.update');
