<?php

namespace App\Http\Controllers\Privates;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Library\Helpers\SeasonHelpers;
use App\Library\NewsLetter\NewsLetter;
use App\Library\StripeCharge;
use App\PrivateLesson;
use App\PrivatePoolSession;
use App\PrivateSwimmer;
use App\Season;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index()
    {
        $private_pool_sessions = PrivatePoolSession::available()->afterNow()->get();

        return view('lessons.private.calendar', ['events' => $private_pool_sessions]);

//        $lessons = Lesson::registrationOpen()->with('group')->get();
//
//        $events = collect();
//        foreach ($lessons as $lesson) {
//            $events->push($lesson->calendarEvents->map(function ($eventDate) use ($lesson) {
//                $eventDate = Carbon::parse($eventDate);
//                return [
//                    'id' => $lesson->id,
//                    'title' => $lesson->group->type,
//                    'description' => 'This is the description',
//                    'start' => Carbon::parse($eventDate->toDateString() . $lesson->class_start_time->toTimeString()),
//                    'end' => Carbon::parse($eventDate->toDateString() . $lesson->class_end_time->toTimeString()),
//                    'color' => $lesson->isFull() ? '#757575' : '#FF4870', //Gray is full and pink is not full
//                    'lesson_id' => $lesson->id
//                ];
//            }));
//        }
//        $events = $events->flatten(1); //Do this to avoid them being grouped by the lesson
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

        $pool_session_ids = explode(',', request()->pool_session_ids);

        //Check the length of the array of pool session id's
        if (!(count($pool_session_ids) > 2)) {
            session()->flash('warning', 'Something went wrong with the lessons selected.');
            return redirect()->back();
        }

        //Make sure the pool sessions are still available
        foreach ($pool_session_ids as $pool_session_id) {
            try {
                PrivatePoolSession::findOrFail($pool_session_id);
            } catch (ModelNotFoundException $exception) {
                session()->flash('warning', 'Sorry, one of the classes was already taken.');
                return redirect()->back();
            } catch (\Exception $exception) {
                session()->flash('warning', 'Sorry, something went wrong with one of the classes.');
                return redirect()->back(500);
            }
        }

        //Charge the card
        $stripe_charge_id = (new StripeCharge(
            request()->stripe_token,
            50, //TODO what is the price for a private lesson?
            request()->email,
            "Private swim lessons for ".request()->first_name." ".request()->last_name." through The Swim School."
        ))->charge()->id;

        //Create the lesson
        $private_lesson = PrivateLesson::create([
            'season_id' => SeasonHelpers::currentSeason()->id
        ]);

        //Create the swimmer
        $private_swimmer = PrivateSwimmer::create([
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'birth_date' => request()->birth_date,
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
                Log::warning('Someone has already taken the pool session id: $pool_session_id');
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

        //TODO: send sign up email
        //TODO: send admin email saying the lesson is full???
        session()->flash("success", "Thanks for signing up! Please check your email for a confirmation.");
        return redirect()->route('pages.thank-you');
    }
}
