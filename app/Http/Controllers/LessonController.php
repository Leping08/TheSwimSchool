<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Lesson;
use App\Swimmer;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\LessonSignUp;
use Illuminate\Support\Facades\Mail;

class LessonController extends Controller
{
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




    //Sign a swimmer up for a lesson and send them to the card payment page or back to the lesson page.
    public function store(Request $request, $classType, $id)
    {
        //valadate data
        $this->validate(request(), [
            'name' => 'required|string|max:191',
            'age' => 'required|digits_between:1,3',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'required|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20',
            'payment' => 'required'
        ]);

        $lesson = Lesson::findOrFail($id);

        $newSwimmer = Swimmer::create([
            'name' => request('name'),
            'age' => request('age'),
            'email' => request('email'),
            'phone' => request('phone'),
            'parent' => request('parent'),
            'street' => request('street'),
            'city' => request('city'),
            'state' => request('state'),
            'zip' => request('zip'),
            'emergencyName' => request('emergencyName'),
            'emergencyRelationship' => request('emergencyRelationship'),
            'emergencyPhone' => request('emergencyPhone'),
            'lesson_id' => $id
        ]);

        //If the user is using a card for payment, send them to the card view with the user id. 
        if(request('payment') === 'card'){
            Mail::to($newSwimmer->email)->send(new LessonSignUp($lesson));
            return view('lessons.cardCheckout', compact('newSwimmer', 'lesson'));
        //If they are paying in person, redirect them to the class they signed up for with success alert.
        }elseif(request('payment') === 'check'){
            //Email the swimmer a confurmation email 
            Mail::to($newSwimmer->email)->send(new LessonSignUp($lesson));
            $request->session()->flash('success', 'You are all signed up! First lesson is '.$lesson->class_start_date->toFormattedDateString().' at '.$lesson->class_start_time->format('H:i A').'. Be sure to bring cash or check for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        }else{
            $request->session()->flash('danger', 'Oops. Looks like something went wrong.');
        }
    }
}
