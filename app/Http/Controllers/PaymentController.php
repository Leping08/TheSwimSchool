<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Swimmer;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    //Charge the card for the correct ammount and mark as payed in DB
    public function ChargeCardForLesson(Request $request, $id)
    {
        //return $request;
        $lesson = Lesson::find($id);
        $swimmer = Swimmer::find($request);

        try{
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $charge = \Stripe\Charge::create(array(
                "amount" => $lesson->price * 100,
                "currency" => "usd",
                "source" => "$request->stripeToken", //Obtained with Stripe.js
                "description" => "Class: ".$lesson->group->type.",\n Swimmer Name: ".$swimmer[0]->name.",\n Card Name: $request->cardholderName,\n Email: $request->cardholderEmail\n"
            ));
            //Mark the as swimmer as payed in the database and save the stripe charge id
            $swimmer[0]->paid = 1;
            $swimmer[0]->stripechargeid = $charge->id;
            $swimmer[0]->save();
            Log::info("Swimmer ID: ".$swimmer[0]->id." has payed with card. Stripe Charge ID: ".$charge->id.".");
            $swimmer[0]->update(['lesson_id' => $lesson->id]);
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
    }
}
