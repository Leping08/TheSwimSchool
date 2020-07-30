<?php

namespace App\Http\Controllers\Privates;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Library\Helpers\SeasonHelpers;
use App\Library\NewsLetter\NewsLetter;
use App\Library\StripeCharge;
use App\Mail\Privates\PrivateLessonSignUp;
use App\PrivateLesson;
use App\PrivatePoolSession;
use App\PrivateSwimmer;
use App\Season;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CalendarController extends Controller
{
    public function index()
    {
        $private_pool_sessions = PrivatePoolSession::with('instructor:id,name,hex_color')->available()->startConditionallyNextMonth()->get();
        $banner = Banner::where('page', '/private-semi-private')->first();

        return view('lessons.private.calendar', ['events' => $private_pool_sessions, 'banner' => $banner]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'birth_date' => 'required|date|before:today',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'nullable|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergency_name' => 'required|max:191',
            'emergency_relationship' => 'required|max:191',
            'emergency_phone' => 'required|max:20',
            'pool_session_ids' => 'required',
            'stripe_token' => 'required'
        ]);

        //Check if the length of the pool session string is just one.
        //This would be when someone only picks one lesson.
        if(strlen(request()->pool_session_ids) == 1) {
            $pool_session_ids = collect(request()->pool_session_ids);
        } else {
            $pool_session_ids = explode(',', request()->pool_session_ids);
        }


        //Check the length of the array of pool session id's
        if (!(count($pool_session_ids) >= 1)) {
            Log::warning("Someone went wrong with lesson selection. Pool session ids array: $pool_session_ids");
            session()->flash('warning', 'Something went wrong with the lesson selection.');
            return redirect()->back();
        }

        //Make sure the pool sessions are still available
        foreach ($pool_session_ids as $pool_session_id) {
            $lesson = PrivatePoolSession::available()->where('id', '=', $pool_session_id)->get();
            if ($lesson->isEmpty()) { //Check if lesson has already been taken
                Log::error("Pool Session Id $pool_session_id has already been taken. Redirecting back.");
                session()->flash('warning', 'Sorry, one of the classes was already taken.');
                return redirect(route('private_lesson.index'));
            }
        }

        //Charge the card
        try {
            $stripe_charge = (new StripeCharge(
                request()->stripe_token,
                (35 * count($pool_session_ids)),  //$35.00 is the cost of one private lesson
                request()->email,
                "Private swim lessons for ".request()->first_name." ".request()->last_name." through The Swim School."
            ))->charge();
            $stripe_charge_id = $stripe_charge->id;
        } catch (\Exception $exception) {
            return back();
        }

        //Create the lesson
        $private_lesson = PrivateLesson::create([
            'season_id' => SeasonHelpers::currentSeason()->id
        ]);

        $birthDate = Carbon::parse(request()->birth_date);

        //Create the swimmer
        $private_swimmer = PrivateSwimmer::create([
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'birth_date' => $birthDate,
            'email' => request()->email,
            'phone' => request()->phone,
            'parent' => request()->parent,
            'notes' => null,
            'street' => request()->street,
            'city' => request()->city,
            'state' => request()->state,
            'zip' => request()->zip,
            'emergency_name' => request()->emergency_name,
            'emergency_relationship' => request()->emergency_relationship,
            'emergency_phone' => request()->emergency_phone,
            'stripe_charge_id' => $stripe_charge_id,
            'private_lesson_id' => $private_lesson->id
        ]);

        //Assign the pool sessions
        foreach ($pool_session_ids as $pool_session_id) {
            $pool_session = PrivatePoolSession::available()->find($pool_session_id);
            if (!$pool_session) {
                Log::warning("Someone has already taken the pool session id: $pool_session_id");
                session()->flash('warning', 'Sorry, one of the classes was already taken.');
                //TODO: Refund the swimmer the charge or schedule different pool sessions, possibly an email here
                return redirect()->back();
            }
            $pool_session->private_lesson_id = $private_lesson->id;
            $pool_session->save();
        }

        //subscribe to the news letter
        if (request()->email_updates == "on") {
            NewsLetter::subscribe(request()->email);
        }

        try {
            Mail::to($private_swimmer->email)->send(new PrivateLessonSignUp($private_lesson));
            Log::info("Sending private lesson sign up email to $private_swimmer->email");
        } catch (\Exception $e) {
            Log::error("Error trying to send private lesson sign up email to $private_swimmer->email. Error:" . $e->getMessage());
        }

        //TODO: send admin email saying the lesson is full???
        //TODO Add logging in here
        session()->flash("success", "Thanks for signing up! Please check your email for a confirmation.");
        return redirect()->route('pages.thank-you');
    }
}
