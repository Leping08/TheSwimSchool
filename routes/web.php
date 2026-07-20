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

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Groups\CertificateController;
use App\Http\Controllers\Groups\LessonsController;
use App\Http\Controllers\Groups\ScheduleController;
use App\Http\Controllers\Groups\SwimmerController;
use App\Http\Controllers\Groups\WaitListController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterEmailController;
use App\Http\Controllers\Privates\CalendarController;
use App\Http\Controllers\RealhabAttendanceController;
use App\Http\Controllers\SwimTeam\AthleteController;
use App\Http\Controllers\SwimTeam\CoachesController;
use App\Http\Controllers\SwimTeam\MeetScheduleController;
use App\Http\Controllers\SwimTeam\RecordsController;
use App\Http\Controllers\SwimTeam\RosterController;
use App\Http\Controllers\SwimTeam\TryoutController;
use Illuminate\Support\Facades\Route;

/* Email testing route */
// Route::get('/email', function () {
//     return new ReturningSwimmerRegistration(\App\STSwimmer::find(1));
// });

/*
 * Home page
 */

Route::get('/', [HomeController::class, 'index'])->name('home.index');

/*
 * Group Lessons
 */

// List lessons
Route::get('/lessons', [LessonsController::class, 'index'])->name('groups.lessons.index');

// Upload a new group lesson schedule PDF (admin only)
Route::post('/lessons/schedule/upload', [ScheduleController::class, 'upload'])->name('groups.schedule.upload')->middleware('auth');

// List details of the group lesson
Route::get('/lessons/{group}', [LessonsController::class, 'show'])->name('groups.lessons.show');

// Sign up form for that lesson
Route::get('/lessons/{group}/{lesson}', [LessonsController::class, 'create'])->name('groups.lessons.create');

// Save the results of the sign up form
Route::post('/lessons/{group}/{lesson}', [SwimmerController::class, 'store'])->name('groups.swimmers.store');

// Show the certificate
Route::get('/lessons/groups/certificate/{encrypted_swimmer_id}', [CertificateController::class, 'show'])->name('groups.certificate.show');

/*
 * Wait List
 */

Route::post('/wait-list/{lesson}', [WaitListController::class, 'store'])->name('groups.lessons.wait-list');

/*
 * Swim Team Tryouts
 */

// The Link to see all tryouts
Route::get('/swim-team/tryouts', [TryoutController::class, 'index'])->name('swim-team.tryouts.index');

// The Link to sign up for a tryout
Route::get('/swim-team/tryouts/{tryout}', [TryoutController::class, 'show'])->name('swim-team.tryouts.show');

// Save the results of the sign up form
Route::post('/swim-team/tryouts/{tryout}', [AthleteController::class, 'store'])->name('swim-team.athlete.store');

// The roster for the current season
Route::get('/roster', [RosterController::class, 'index'])->name('swim-team.roster.index');

// Record Holders PDF upload
Route::post('/swim-team/records/upload', [RecordsController::class, 'upload'])->name('swim-team.records.upload')->middleware('auth');
// Meet Schedule PDF upload
Route::post('/swim-team/meet-schedule/upload', [MeetScheduleController::class, 'upload'])->name('swim-team.meet-schedule.upload')->middleware('auth');
// USA Competitive Meet Schedule PDF upload
Route::post('/swim-team/usa-meet-schedule/upload', [MeetScheduleController::class, 'uploadUsaCompetitive'])->name('swim-team.usa-meet-schedule.upload')->middleware('auth');

/*
 * Swim Team Registration
 */

Route::get('/swim-team', [CoachesController::class, 'index'])->name('swim-team.index');

// Register the new swimmer for the swim team
Route::get('/swim-team/athlete/{hash}', [App\Http\Controllers\SwimTeam\SwimmerController::class, 'index'])->name('swim-team.swimmer.show');

// todo deprecate soon
// Register the old swimmer for the swim team
Route::get('/swim-team/register/{level}/swimmer/{swimmer}', [App\Http\Controllers\SwimTeam\SwimmerController::class, 'register'])->name('swim-team.swimmer.register');
Route::get('/swim-team/save-swimmer/level/{level}/swimmer/{swimmer}', [App\Http\Controllers\SwimTeam\SwimmerController::class, 'store2'])->name('swim-team.swimmer.store2');

// Register the new athlete for the swim team
Route::get('/swim-team/save-swimmer/athlete/{hash}', [App\Http\Controllers\SwimTeam\SwimmerController::class, 'store3'])->name('swim-team.swimmer.create');

Route::get('/swim-team/thank-you', [App\Http\Controllers\SwimTeam\SwimmerController::class, 'thankYou'])->name('swim-team.thank-you');

/*
 * Public Contact Forms
 */

Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');

Route::get('/private-semi-private', [CalendarController::class, 'index'])->name('private_lesson.index');

Route::post('/private-semi-private', [CalendarController::class, 'store'])->name('private_lesson.store');

/*
 * Email marketing unsubscribe page
 */

// todo check why we have post and get for unsubscribe
Route::get('/newsletter/unsubscribe/{email}', [EmailListController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::post('/newsletter/unsubscribe/{email}', [EmailListController::class, 'unsubscribe']);

Route::post('/newsletter/subscribe', [EmailListController::class, 'subscribe'])->name('newsletter.subscribe');

/*
 * Email marketing unsubscribe page
 */

// todo is this still being used?
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

/*
 * Instructor specific calendar
 */

Route::get('/calendar/{instructor}', [App\Http\Controllers\Admin\CalendarController::class, 'show'])->name('calendar')->middleware('auth');

/*
 * About Page
 */

Route::get('/about', [AboutController::class, 'index'])->name('pages.about');

/*
 * Custom Email
 */

Route::middleware(['auth'])->group(function () {
    Route::get('/emails/newsletter', [NewsletterEmailController::class, 'index'])->name('newsletter.index');

    Route::get('/emails/newsletter/show', [NewsletterEmailController::class, 'show'])->name('newsletter.show');

    Route::post('/emails/newsletter/store', [NewsletterEmailController::class, 'store'])->name('newsletter.store');

    Route::post('/emails/newsletter/view-preview', [NewsletterEmailController::class, 'preview'])->name('newsletter.preview.view');

    Route::post('/emails/newsletter/send-preview', [NewsletterEmailController::class, 'sendPreview'])->name('newsletter.preview.send');

    Route::post('/emails/newsletter/send-emails', [NewsletterEmailController::class, 'sendEmails'])->name('newsletter.send');

    Route::post('/emails/newsletter/upload-image', [NewsletterEmailController::class, 'uploadImage'])->name('newsletter.upload-image');

    Route::get('/realhab-attendance', [RealhabAttendanceController::class, 'index'])->name('realhab-attendance.index');
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
