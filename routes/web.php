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


//Auth routes
Route::middleware('auth')->group(function () {
    //Swimmers
    Route::get('/swimmers', 'SwimmerController@index');
    Route::get('/swimmers/{id}', 'SwimmerController@show');
    Route::delete('/swimmers/{id}', 'SwimmerController@destroy');
    Route::get('/swimmers/{id}/edit', 'SwimmerController@edit');
    Route::patch('/swimmers/{id}/edit', 'SwimmerController@update');

    //Dashboard
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/season/current', 'DashboardController@swimmersForCurrentSeason');

    Route::resource('groups', 'GroupController');
    Route::resource('locations', 'LocationController');

    //TODO: Fix admin view for a single lesson
    //Route::get('lessons/{id}', 'LessonController@show');
    Route::post('/lessons', 'LessonController@store');
    //Route::resource('lesson', 'LessonController');
});


//list lessons
Route::get('/lessons', 'GroupController@index');

//list details of the lesson
Route::get('/lessons/{groupType}', 'GroupController@classDetails');

//sign up form for that lesson
Route::get('/lessons/{classType}/{id}', 'GroupController@signUp');

//save the results of the sign up form
Route::post('/lessons/{classType}/{id}', 'SwimmerController@store');

//charge the credit card for the lesson
Route::post('/{id}/card/checkout', 'PaymentController@ChargeCardForLesson');

//show the terms and conditions page
Route::get('/lessons/{classType}/{id}/terms', 'GroupController@terms');





//WP pages
Route::get('/', function(){
    return view('pages.home');
});

Route::get('/services', function(){
    return view('pages.services');
});

Route::get('/lifeguarding', function(){
    return view('pages.lifeguarding');
});

Route::get('/cpr-first-aid', function(){
    return view('pages.cpr-first-aid');
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




//WP Contact Forms
Route::post('/contact-us', 'ContactFormsController@contactUs');
Route::post('/lifeguarding', 'ContactFormsController@lifeguarding');
Route::post('/cpr-first-aid', 'ContactFormsController@cprFirstAid');


