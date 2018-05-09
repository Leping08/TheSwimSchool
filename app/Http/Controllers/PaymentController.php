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

        $charge = $this->chargeCard($lesson, $request, $swimmer);

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
                Log::error("Email error: ".$e);
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
            Log::error("Email error: ".$e);
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

    /**
     * @param Swimmer $swimmer
     * @param Lesson $lesson
     * @param $charge
     */
    private function updateSwimmerWithPayment(Swimmer $swimmer, Lesson $lesson, $charge)
    {
        //Mark the as swimmer as payed in the database and save the stripe charge id
        //TODO if the payment is declined by the bank don't do this step
        $swimmer->paid = 1;
        $swimmer->stripechargeid = $charge->id;
        $swimmer->save();
        Log::info("Swimmer ID: ".$swimmer->id." has payed with card. Stripe Charge ID: ".$charge->id.".");

        $swimmer->update(['lesson_id' => $lesson->id]);
        Log::info("Swimmer: $swimmer->firstName $swimmer->lastName with ID: $swimmer->id signed up for lesson ID: $swimmer->lesson_id");
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @param Swimmer $swimmer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Stripe\Charge
     */
    private function chargeCard(Lesson $lesson, Request $request, Swimmer $swimmer)
    {
        //TODO: Bank declines but they still sign up successfully
        $newSwimmer = $swimmer;
        try{
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            return \Stripe\Charge::create(array(
                "amount" => $lesson->price * 100,
                "currency" => "usd",
                "receipt_email" => "$request->cardholderEmail",
                "description" => $lesson->group->type." swim lessons for $swimmer->firstName $swimmer->lastName through The Swim School.",
                "source" => "$request->stripeToken" //Obtained with Stripe.js
            ));
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
