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
use App\Library\StripeCharge;


class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @param StripeCharge $stripe
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function ChargeCardForLesson(Request $request, $id, StripeCharge $stripe)
    {
        $request->validate([
            'cardholderName' => 'required',
            'cardholderEmail' => 'required',
            'swimmerId' => 'required'
        ]);

        //TODO: Validate the email and name here
        $lesson = Lesson::find($id);
        $swimmer = Swimmer::find($request->swimmerId);

        $this->abortIfLessonIsFull($lesson, $swimmer);

        $charge = $stripe->pay($request->stripeToken, $lesson->price, $request->cardholderEmail, $lesson->group->type . " swim lessons for $swimmer->firstName $swimmer->lastName through The Swim School.");

        $this->updateSwimmerWithPayment($swimmer, $lesson, $charge);

        $request->session()->flash('success', 'Thanks for signing up! The first lesson is '.$lesson->class_start_date->format('F jS').' at '.$lesson->class_start_time->format('g:i a'));
        return redirect('lessons/'.$lesson->class_type);
    }

    /**
     * @param Lesson $lesson
     */
    private function sendClassFullEmail(Lesson $lesson) {
        if($lesson->isFull()){
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
        $this->sendClassFullEmail($lesson);
    }

    /**
     * @param Lesson $lesson
     * @param Swimmer $swimmer
     * @return \Illuminate\Http\RedirectResponse
     */
    private function abortIfLessonIsFull(Lesson $lesson, Swimmer $swimmer)
    {
        if($lesson->isFull()){
            session()->flash('danger', 'Sorry the lesson is full.');
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
        $swimmer->stripechargeid = $charge->id;
        $swimmer->paid = 1;
        $swimmer->save();
        Log::info("Swimmer ID: ".$swimmer->id." has payed with card. Stripe Charge ID: ".$charge->id.".");

        $swimmer->update(['lesson_id' => $lesson->id]);
        Log::info("Swimmer: $swimmer->firstName $swimmer->lastName with ID: $swimmer->id signed up for lesson ID: $swimmer->lesson_id");

        $this->sendClassSignUpEmail($lesson, $swimmer);
    }
}
