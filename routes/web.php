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

//aka dashboard
Route::get('/home', 'HomeController@index');






//list lessons
Route::get('/lessons', 'LessonController@index');

//list details of the lesson
Route::get('/lessons/{classType}', 'LessonController@classDetails');

//sign up form for that lesson
Route::get('/lessons/{classType}/{id}', 'LessonController@signUp');

//save the results of the sign up form
Route::post('/lessons/{classType}/{id}', 'LessonController@store');

//credit card form if online payment
//Route::get('/lessons/{classType}/{id}/card', 'LessonController@cardForm');

//charge the credit card for the lesson
Route::post('/{id}/card/test', 'LessonController@cardCharge');
//Route::post('/lessons/{classType}/{id}/card/test', 'LessonController@cardCharge');

//show the terms and conditions page
Route::get('/lessons/{classType}/{id}/terms', 'LessonController@terms');







//swimmers
Route::get('/swimmers', 'SwimmerController@index');

Route::get('/swimmers/{id}', 'SwimmerController@show');

Route::delete('/swimmers/{id}', 'SwimmerController@destroy');

Route::get('/swimmers/{id}/edit', 'SwimmerController@edit');

Route::patch('/swimmers/{id}/edit', 'SwimmerController@update');






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
Route::post('/contact-us', 'EmailController@contactUs');

Route::post('/lifeguarding', 'EmailController@lifeguardingEmail');

Route::post('/cpr-first-aid', 'EmailController@cprFirstAidEmail');

Route::get('/email-test', 'EmailController@testEmail');

Route::get('/email', 'EmailController@index');


