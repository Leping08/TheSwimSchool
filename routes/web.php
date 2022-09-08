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

use App\Mail\SwimTeam\STSignUp;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// handel strip errors better
// add loading state to stripe button

/* Email testing route */
Route::get('/email-test/swim-team-registration', function () {
    return new STSignUp(\App\STSwimmer::find(1));
});


/* @see \Laravel\Ui\AuthRouteMethods::auth() */
Auth::routes(['login' => true, 'logout' => true, 'reset' => true]);

/*
 * Home page
 */

/* @see HomeController::index() */
Route::get('/', 'HomeController@index')->name('home.index');



/*
 * Group Lessons
 */

//List lessons
/* @see LessonsController::index() */
Route::get('/lessons', 'Groups\LessonsController@index')->name('groups.lessons.index');

//Get the lesson schedule page
/* @see ScheduleController::index() */
Route::get('/lessons/schedule', 'Groups\ScheduleController@index')->name('groups.schedule.index');

//List details of the group lesson
/* @see LessonsController::show() */
Route::get('/lessons/{group}', 'Groups\LessonsController@show')->name('groups.lessons.show');

//Sign up form for that lesson
/* @see LessonsController::create() */
Route::get('/lessons/{group}/{lesson}', 'Groups\LessonsController@create')->name('groups.lessons.create');

//Save the results of the sign up form
/* @see SwimmerController::store() */
Route::post('/lessons/{group}/{lesson}', 'Groups\SwimmerController@store')->name('groups.swimmers.store');




/*
 * Wait List
 */

/* @see WaitListController::store() */
Route::post('/wait-list/{lesson}', 'Groups\WaitListController@store')->name('groups.lessons.wait-list');




/*
 * Swim Team Tryouts
 */

//The Link to see all tryouts
/* @see TryoutController::index() */
Route::get('/swim-team/tryouts', 'SwimTeam\TryoutController@index')->name('swim-team.tryouts.index');

//The Link to sign up for a tryout
/* @see TryoutController::show() */
Route::get('/swim-team/tryouts/{tryout}', 'SwimTeam\TryoutController@show')->name('swim-team.tryouts.show');

//Save the results of the sign up form
/* @see AthleteController::store() */
Route::post('/swim-team/tryouts/{tryout}', 'SwimTeam\AthleteController@store')->name('swim-team.athlete.store');

//The roster for the current season
/* @see RosterController::index() */
Route::get('/roster', 'SwimTeam\RosterController@index')->name('swim-team.roster.index');




/*
 * Swim Team Registration
 */

/* @see CoachesController::index() */
Route::get('/swim-team', 'SwimTeam\CoachesController@index')->name('swim-team.index');

/* @see SwimmerController::index() */
// this shows the sign up form with everything pre filled
Route::get('/swim-team/level/{level}/swimmer/{athlete?}', 'SwimTeam\SwimmerController@index')->name('swim-team.swimmer.show');

/* @see SwimmerController::register() */
Route::get('/swim-team/register/{level}/swimmer/{swimmer}', 'SwimTeam\SwimmerController@register')->name('swim-team.swimmer.register');

/* @see SwimmerController::store() */
// Route::post('/swim-team/level/{level}/swimmer/{athlete?}', 'SwimTeam\SwimmerController@store')->name('swim-team.swimmer.store');

/* @see SwimmerController::store2() */
// this runs the logic to save the data that was submitted after the stripe charge
Route::get('/swim-team/save-swimmer/level/{level}/swimmer/{swimmer}', 'SwimTeam\SwimmerController@store2')->name('swim-team.swimmer.store2');

Route::get('/swim-team/thank-you', 'SwimTeam\SwimmerController@thankYou')->name('swim-team.thank-you');



/*
 * Public Contact Forms
 */

/* @see LeadController::store() */
Route::post('/contact-us', 'LeadController@store')->name('contact-us.store');

/* @see CalendarController::index() */
Route::get('/private-semi-private', 'Privates\CalendarController@index')->name('private_lesson.index');

/* @see CalendarController::store() */
Route::post('/private-semi-private', 'Privates\CalendarController@store')->name('private_lesson.store');

/* @see LeadController::index() */
Route::get('/home-private-lesson', 'Privates\LeadController@index')->name('home_privates.index');

/* @see LeadController::store() */
Route::post('/home-private-lesson', 'Privates\LeadController@store')->name('home_privates.store');




/*
 * Email marketing unsubscribe page
 */

/* @see EmailListController::unsubscribe() */
Route::get('/newsletter/unsubscribe/{email}', 'EmailListController@unsubscribe')->name('newsletter.unsubscribe');

/* @see EmailListController::unsubscribe() */
Route::post('/newsletter/unsubscribe/{email}', 'EmailListController@unsubscribe');

/* @see EmailListController::subscribe() */
Route::post('/newsletter/subscribe', 'EmailListController@subscribe')->name('newsletter.subscribe');




/*
 * Email marketing unsubscribe page
 */

/* @see FeedbackController::index() */
Route::get('/feedback', 'FeedbackController@index')->name('feedback.index');

/* @see FeedbackController::store() */
Route::post('/feedback', 'FeedbackController@store')->name('feedback.store');




/*
 * Instructor specific calendar
 */

/* @see CalendarController::show() */
Route::get('/calendar/{instructor}', 'Admin\CalendarController@show')->name('calendar')->middleware('auth');




/*
 * About Page
 */

/* @see AboutController::index() */
Route::get('/about', 'AboutController@index')->name('pages.about');



/*
 * Custom Email
 */

Route::middleware(['auth'])->group(function () {
    
    /* @see NewsletterEmailController::index() */
    Route::get('/emails/newsletter', 'NewsletterEmailController@index')->name('newsletter.index');

    /* @see NewsletterEmailController::show() */
    Route::get('/emails/newsletter/show', 'NewsletterEmailController@show')->name('newsletter.show');
    
    /* @see NewsletterEmailController::store() */
    Route::post('/emails/newsletter/store', 'NewsletterEmailController@store')->name('newsletter.store');
    
    /* @see NewsletterEmailController::preview() */
    Route::post('/emails/newsletter/view-preview', 'NewsletterEmailController@preview')->name('newsletter.preview.view');
    
    /* @see NewsletterEmailController::sendPreview() */
    Route::post('/emails/newsletter/send-preview', 'NewsletterEmailController@sendPreview')->name('newsletter.preview.send');

    /* @see NewsletterEmailController::sendEmails() */
    Route::post('/emails/newsletter/send-emails', 'NewsletterEmailController@sendEmails')->name('newsletter.send');

    /* @see NewsletterEmailController::uploadImage() */
    Route::post('/emails/newsletter/upload-image', 'NewsletterEmailController@uploadImage')->name('newsletter.upload-image');
});



/*
 * Static Pages
 */

 Route::get('/contact-us', function () {
    return view('pages.contact-us');
})->name('pages.contact-us');

Route::get('/group-lessons/policies-and-procedures', function () {
    return view('groups.terms');
})->name('groups.terms');

Route::get('/swim-team/policies-and-procedures', function () {
    return view('swim-team.terms');
})->name('swim-team.terms');

Route::get('/thank-you', function () {
    return view('pages.thank-you');
})->name('pages.thank-you');
