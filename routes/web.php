<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


//Auth protected routes
Route::middleware('auth')->group(function () {
    //Swimmers
    Route::get('/swimmers', 'SwimmerController@index');
    Route::get('/swimmers/{id}', 'SwimmerController@show');
    Route::delete('/swimmers/{id}', 'SwimmerController@destroy');
    Route::get('/swimmers/{id}/edit', 'SwimmerController@edit');
    Route::patch('/swimmers/{id}/edit', 'SwimmerController@update');

    /* @see DashboardController::index() */
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/analytics', 'DashboardController@analytics');
    Route::get('/dashboard/season/current', 'DashboardController@swimmersForCurrentSeason');

    /* @see PrivateLessonLeadController::show() */
    Route::get('/private-semi-private/lead/{id}', 'PrivateLessonLeadController@show');

    /* @see LeadController::show() */
    Route::get('/lead/{id}', 'LeadController@show');

    /* @see GroupController */
    Route::resource('groups', 'GroupController');
    /* @see LocationController */
    Route::resource('locations', 'LocationController');
    /* @see LessonController */
    Route::resource('lesson', 'LessonController');
});


//List lessons
/* @see GroupController::index() */
Route::get('/lessons', 'GroupController@index');

//List details of the lesson
/* @see GroupController::classDetails() */
Route::get('/lessons/{groupType}', 'GroupController@classDetails');

//Sign up form for that lesson
/* @see GroupController::signUp() */
Route::get('/lessons/{classType}/{id}', 'GroupController@signUp');

//Save the results of the sign up form
/* @see SwimmerController::store() */
Route::post('/lessons/{classType}/{id}', 'SwimmerController@store');

//Charge the credit card for the lesson
/* @see PaymentController::ChargeCardForLesson() */
Route::post('/{id}/card/checkout', 'PaymentController@ChargeCardForLesson');

//The Link to sign up for private lessons
/* @see SwimmerController::store() */
Route::get('/private/{classType}/{id}', 'SwimmerController@store');

//The Link to see all tryouts
/* @see TryoutController::index() */
Route::get('/swim-team/tryouts', 'TryoutController@index');

//The Link to sign up for a tryout
/* @see TryoutController::show() */
Route::get('/swim-team/tryouts/{id}', 'TryoutController@show');







//Static Pages
Route::get('/', function(){
    return view('pages.home');
});

Route::get('/services', function(){
    return view('pages.services');
});

Route::get('/swim-team', function(){
    return view('swim-team.swim-team');
});

Route::get('/about', function(){
    return view('pages.about');
});

Route::get('/testimonials', function(){
    return view('pages.testimonials');
});

Route::get('/contact-us', function(){
    return view('pages.contact-us');
});

Route::get('/other-services', function (){
   return view('pages.other-services');
});

Route::get('/lifeguarding', function (){
    return view('pages.lifeguarding');
});

Route::get('/cpr-first-aid', function(){
    return view('pages.cpr-first-aid');
});

Route::get('/policies-and-procedures', function(){
    return view('groups.terms');
});

Route::get('/private-semi-private', function () {
    return view('private-lesson-leads.index');
});



//WP Contact Forms
/* @see LeadController::contact() */
Route::post('/contact-us', 'LeadController@contact');

/* @see LeadController::contact() */
Route::post('/lifeguarding', 'LeadController@contact');

/* @see LeadController::contact() */
Route::post('/cpr-first-aid', 'LeadController@contact');

/* @see LeadController::contact() */
Route::post('/private-semi-private', 'LeadController@contact');

/* @see PrivateLessonLeadController::store() */
Route::post('/private-semi-private', 'PrivateLessonLeadController@store');