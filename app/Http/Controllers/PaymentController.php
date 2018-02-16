<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Swimmer;
use App\Mail\SignUp;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    //Charge the card for the correct ammount and mark as payed in DB
    public function ChargeCardForLesson(Request $request, $id)
    {
        //TODO: Validate the email and name here
        $lesson = Lesson::find($id);
        $swimmer = Swimmer::find($request->swimmerId);

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

            Log::info("Swimmer: $swimmer->firstName $swimmer->lastName with ID: $swimmer->id signed up for lesson ID: $swimmer->lesson_id");
            Mail::to($swimmer->email)->send(new SignUp($lesson));
            Log::info("Group Lesson sign up email sent to $swimmer->email. Swimmer ID: $swimmer->id Lesson ID: $lesson->id.");
            //TODO: add signup email to the que
            //SignupEmail::dispatch($lesson, $newSwimmer->email);

            Log::info("Swimmer ID: ".$swimmer->id." has payed with card. Stripe Charge ID: ".$charge->id.".");
            $swimmer->update(['lesson_id' => $lesson->id]);
            $request->session()->flash('success', 'Thanks for your payment of $'.$lesson->price.'. First lesson is '.$lesson->class_start_date->toFormattedDateString().' at '.$lesson->class_start_time->format('H:i A'));

            //Send lesson full email if this user filled up the lesson
            if($lesson->isLessonFull()){
                foreach(config('mail.leadDestEmails') as $emailAddress){
                    Mail::to($emailAddress)->send(new ClassFull($lesson));
                }
            }

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
    }
}
