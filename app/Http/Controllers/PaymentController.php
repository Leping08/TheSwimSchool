<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Swimmer;
use App\Mail\SignUp;
use App\Mail\ClassFull;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    //Charge the card for the correct ammount and mark as payed in DB
    public function ChargeCardForLesson(Request $request, $id)
    {
        $request->validate([
            'cardholderName' => 'required',
            'cardholderEmail' => 'required',
            'swimmerId' => 'required'
        ]);

        //TODO: Validate the email and name here
        $lesson = Lesson::find($id);
        $swimmer = Swimmer::find($request->swimmerId);
        $newSwimmer = $swimmer;

        //Check to see if the lesson is full
        if($lesson->isLessonFull()){
            $request->session()->flash('danger', 'Sorry the lesson is full.');
            return back();
        }

        try{
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $charge = \Stripe\Charge::create(array(
                "amount" => $lesson->price * 100,
                "currency" => "usd",
                "receipt_email" => "$request->cardholderEmail",
                "description" => $lesson->group->type." swim lessons for $swimmer->firstName $swimmer->lastName through The Swim School.",
                "source" => "$request->stripeToken" //Obtained with Stripe.js
            ));
            //Mark the as swimmer as payed in the database and save the stripe charge id
            $swimmer->paid = 1;
            $swimmer->stripechargeid = $charge->id;
            $swimmer->save();
            Log::info("Swimmer ID: ".$swimmer->id." has payed with card. Stripe Charge ID: ".$charge->id.".");

            $swimmer->update(['lesson_id' => $lesson->id]);
            Log::info("Swimmer: $swimmer->firstName $swimmer->lastName with ID: $swimmer->id signed up for lesson ID: $swimmer->lesson_id");

            try {
                Mail::to($swimmer->email)->send(new SignUp($lesson));
                Log::info("Group Lesson sign up email sent to $swimmer->email. Swimmer ID: $swimmer->id Lesson ID: $lesson->id.");
                //Add signup email to the que
                //SignupEmail::dispatch($lesson, $newSwimmer->email);
            } catch (\Exception $e) {
                Log::error("Email error: ".$e);
            }

            //Send lesson full email if this user filled up the lesson
            //TODO: Test to see if lesson full email works
            if($lesson->isLessonFull()){
                try {
                    foreach(config('mail.leadDestEmails') as $emailAddress){
                        Log::info("Sending lesson full email to $emailAddress");
                        Mail::to($emailAddress)->send(new ClassFull($lesson));
                    }
                } catch (\Exception $e) {
                    Log::error("Email error: ".$e);
                }
            }

            $request->session()->flash('success', 'Thanks for signing up! The first lesson is '.$lesson->class_start_date->format('g:ia').' at '.$lesson->class_start_time->format('H:i A'));

            return redirect('lessons/'.$lesson->class_type);
        } catch(Card $e){
            $body = $e->getJsonBody();
            $err  = $body['error'];
            Log::error($err['message']);
            $request->session()->flash('error', $err['message']);
            return view('swimmers.cardCheckout', compact('lesson', 'newSwimmer'));
        } catch (InvalidRequest $e){
            Log::error('Invalid parameters were supplied to Stripes API');
            $request->session()->flash('error', 'Oops, something went wrong with the payment.');
            return view('swimmers.cardCheckout', compact('lesson', 'newSwimmer'));
        } catch (Authentication $e){
            Log::error('Authentication with Stripes API failed (maybe you changed API keys recently)');
            $request->session()->flash('error', 'Oops, something went wrong with the payment.');
            return view('swimmers.cardCheckout', compact('lesson', 'newSwimmer'));
        }  catch (Base $e) {
            Log::error('Generic error occurred');
            $request->session()->flash('error', 'Oops, something went wrong with the payment.');
            return view('swimmers.cardCheckout', compact('lesson', 'newSwimmer'));
        }
    }
}
