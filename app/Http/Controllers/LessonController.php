<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Lesson;
use App\Swimmer;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with(['Group', 'Location', 'Season', 'DaysOfTheWeek'])
            ->where('id', '=', $id)
            ->get();
        $days = Lesson::findorfail($id)->DaysOfTheWeek()->get();
        return view('lessons.show', compact('lesson', 'days'));
    }

    public function store(Request $request)
    {
        $lesson = $request->validate([
            'group_id' => 'required|digits_between:1,6',
            'location_id' => 'required|digits_between:1,6',
            'price' => 'required|digits_between:1,3',
            'registration_open' => 'required|string',
            'class_size' => 'required|digits_between:1,3',
            'class_start_time' => 'required|string',
            'class_end_time' => 'required|string',
            'class_start_date' => 'required|string',
            'class_end_date' => 'required|string'
        ]);

        $lesson['registration_open'] = Carbon::parse($lesson['registration_open']);
        $lesson['class_start_time'] = Carbon::parse($lesson['class_start_time']);
        $lesson['class_end_time'] = Carbon::parse($lesson['class_end_time']);
        $lesson['class_start_date'] = Carbon::parse($lesson['class_start_date']);
        $lesson['class_end_date'] = Carbon::parse($lesson['class_end_date']);
        $lesson['season_id'] =  GetSeason::getSeasonFromDate($lesson['class_start_date'])->id;

        $newLesson = Lesson::create($lesson);

        if($request['sunday']){
            $newLesson->DaysOfTheWeek()->attach(1);
        }
        if($request['monday']){
            $newLesson->DaysOfTheWeek()->attach(2);
        }
        if($request['tuesday']){
            $newLesson->DaysOfTheWeek()->attach(3);
        }
        if($request['wednesday']){
            $newLesson->DaysOfTheWeek()->attach(4);
        }
        if($request['thursday']){
            $newLesson->DaysOfTheWeek()->attach(5);
        }
        if($request['friday']){
            $newLesson->DaysOfTheWeek()->attach(6);
        }
        if($request['saturday']){
            $newLesson->DaysOfTheWeek()->attach(7);
        }

        return back();
    }


    //Charge the card for the correct ammount and mark as payed in DB
    public function cardCharge(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        try{
            $swimmer = Swimmer::findOrFail($request->swimmerId);
            \StrStripe::setApiKey(config('services.stripe.secret'));
            $charge = \Stripe\Charge::create(array(
                "amount" => $lesson->price * 100,
                "currency" => "usd",
                "source" => "$request->stripeToken", //Obtained with Stripe.js
                "description" => "
                                Class: $lesson->class_type,
                                Swimmer Name: $request->cardholderName,
                                Card Name: $request->cardholderName,
                                Email: $request->cardholderEmail
                                "
            ));
            //Mark the as swimmer as payed in the database and save the stripe charge id
            $stripechargeid = $charge->id;
            $swimmer->update(['paid' => 1, 'stripechargeid' => $stripechargeid]);
            $request->session()->flash('success', 'Thanks for your payment of $'.$lesson->price.'. First lesson is '.$lesson->class_start_date->toFormattedDateString().' at '.$lesson->class_start_time->format('H:i A'));
            return redirect('lessons/'.$lesson->class_type);
        } catch(Card $e){
            //Card decline error
            $body = $e->getJsonBody();
            $err  = $body['error'];
            Log::error($err['message']);
            $request->session()->flash('error', $err['message'].' Dont worry you are signed up. Just bring a check or cash for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        } catch (InvalidRequest $e){
            //Invalid parameters were supplied to Stripe's API
            Log::error('Invalid parameters were supplied to Stripes API');
            $request->session()->flash('error', 'Oops, something went wrong with the payment. Dont worry you are signed up. Just bring a check or cash for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        } catch (Authentication $e){
            //Authentication with Stripe's API failed (maybe you changed API keys recently)
            Log::error('Authentication with Stripes API failed (maybe you changed API keys recently)');
            $request->session()->flash('error', 'Oops, something went wrong with the payment. Dont worry you are signed up. Just bring a check or cash for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        }  catch (Base $e) {
            Log::error('Generic error occurred');
            $request->session()->flash('error', 'Oops, something went wrong with the payment. Dont worry you are signed up. Just bring a check or cash for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        }
        //return view('lessons.thanks');
    }
}
