<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Swimmer;
use App\Mail\SignUp;
use App\Mail\ClassFull;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Error\InvalidRequest;

//TODO: Refactor this controller with the new stripe class App\Library\StripeCharge
class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

        $this->abortIfLessonIsFull($lesson, $request, $swimmer);

        try {
            $charge = $this->chargeCard($lesson, $request, $swimmer);
        } catch (\Exception $e){
            Log::error(print_r(request()->server(), true));
            Log::error("Exception: ".$e->getMessage());
            Log::error('Something went wrong with the payment sending the user back to the checkout view.');
            $newSwimmer = $swimmer;
            return view('swimmers.cardCheckout', compact('lesson', 'newSwimmer'));
        }

        $this->updateSwimmerWithPayment($swimmer, $lesson, $charge);

        $this->sendClassSignUpEmail($lesson, $swimmer);

        $this->sendClassFullEmail($lesson);

        $request->session()->flash('success', 'Thanks for signing up! The first lesson is '.$lesson->class_start_date->format('F jS').' at '.$lesson->class_start_time->format('g:i a'));
        return redirect('lessons/'.$lesson->class_type);
    }

    /**
     * @param Lesson $lesson
     */
    private function sendClassFullEmail(Lesson $lesson) {
        if($lesson->isLessonFull()){
            try {
                foreach(config('mail.leadDestEmails') as $email){
                    Log::info("Sending lesson full email to $email. Lesson ID: $lesson->id");
                    Mail::to($email)->send(new ClassFull($lesson));
                }
            } catch (\Exception $e) {
                Log::error("Email error: ");
                Log::error(print_r($e, true));
            }
        }
    }

    /**
     * @param Lesson $lesson
     * @param Swimmer $swimmer
     */
    private function sendClassSignUpEmail(Lesson $lesson, Swimmer $swimmer)
    {
        try {
            Mail::to($swimmer->email)->send(new SignUp($lesson));
            Log::info("Group Lesson sign up email sent to $swimmer->email. Swimmer ID: $swimmer->id Lesson ID: $lesson->id.");
        } catch (\Exception $e) {
            Log::error("Email error: ");
            Log::error(print_r($e, true));
        }
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @param Swimmer $swimmer
     * @return \Illuminate\Http\RedirectResponse
     */
    private function abortIfLessonIsFull(Lesson $lesson, Request $request, Swimmer $swimmer)
    {
        if($lesson->isLessonFull()){
            $request->session()->flash('danger', 'Sorry the lesson is full.');
            Log::warning("Swimmer ID: $swimmer->id tried to sign up for a lesson that is full.");
            return back();
        }
    }


    private function updateSwimmerWithPayment(Swimmer $swimmer, Lesson $lesson, $charge)
    {
        //Mark the as swimmer as payed in the database and save the stripe charge id
        //TODO if the payment is declined by the bank don't do this step
        $swimmer->stripechargeid = $charge->id;
        $swimmer->paid = 1;
        $swimmer->save();
        Log::info("Swimmer ID: ".$swimmer->id." has payed with card. Stripe Charge ID: ".$charge->id.".");

        $swimmer->update(['lesson_id' => $lesson->id]);
        Log::info("Swimmer: $swimmer->firstName $swimmer->lastName with ID: $swimmer->id signed up for lesson ID: $swimmer->lesson_id");
    }


    private function chargeCard(Lesson $lesson, Request $request, Swimmer $swimmer)
    {
        //TODO: Bank declines but they still sign up successfully

        $charge = array(
            "amount" => $lesson->price * 100,
            "currency" => "usd",
            "receipt_email" => "$request->cardholderEmail",
            "description" => $lesson->group->type . " swim lessons for $swimmer->firstName $swimmer->lastName through The Swim School.",
            "source" => "$request->stripeToken" //Obtained with Stripe.js
        );

        Log::info('Stripe charge request array for swimmer ID'. $swimmer->id);
        Log::info(print_r($charge, true));

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            return \Stripe\Charge::create($charge);
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            Log::error('Since its a decline, \Stripe\Error\Card will be caught');
            $this->logStripeError($e);
            throw new \Exception($e);
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            Log::error('Too many requests made to the API too quickly');
            $this->logStripeError($e);
            throw new \Exception($e);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            Log::error('Invalid parameters were supplied to Stripes API');
            $this->logStripeError($e);
            throw new \Exception($e);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed (maybe you changed API keys recently)
            Log::error('Authentication with Stripes API failed (maybe you changed API keys recently)');
            $this->logStripeError($e);
            throw new \Exception($e);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            Log::error('Network communication with Stripe failed');
            $this->logStripeError($e);
            throw new \Exception($e);
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send yourself an email
            Log::error('Display a very generic error to the user, and maybe send yourself an email');
            $this->logStripeError($e);
            throw new \Exception($e);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            Log::error('Something else happened, completely unrelated to Stripe');
            Log::error('Error: ' . $e->getMessage());
            throw new \Exception($e);
        }
    }


    /**
     * @param $e
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function logStripeError($e)
    {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        Log::error('Status is:' . $e->getHttpStatus());
        Log::error('Type is:' . $err['type']);
        Log::error('Code is:' . $err['code']);
        Log::error(print_r($err, true));
        session()->flash('error', 'Oops, something went wrong with the payment. ' . $err['message']);
    }
}
