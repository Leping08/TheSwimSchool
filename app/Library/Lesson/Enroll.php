<?php

namespace App\Library\Lesson;

use App\Lesson;
use App\Library\NewsLetter\NewsLetter;
use App\Library\StripeCharge;
use App\Mail\Admin\ClassFull;
use App\Mail\Groups\SignUp;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

/**
 *** Validate data                        - separate class Laravel FormRequest
 *** Check if lesson if full              - separate class lesson->isFull()
 *** Process the payment                  - separate class (new StripeCharge($token, $price, $email, $description))->pay()
 *     Promo code logic                 - separate class ??????
 *** Create the swimmer
 *** Subscribe to news letter             - separate class NewsLetter::subscribe($email)
 *** Send class sign up email
 *** Send class full email to admin       - separate class
 * Flash success
 * Redirect back to lesson they signed up for
 */
class Enroll
{
    public function handle()
    {
        // Validation happens on the controller
        if ($this->isFull()) {
            Log::warning('Someone tried to sign up for a lesson that is full.');
            session()->flash('danger', 'Sorry the lesson is full.');

            return back();
        }
        $lesson = $this->getLesson();
        $chargeId = $this->processPayment($lesson);
        $swimmer = $this->createSwimmer($chargeId);
        $this->subscribeToNewsLetter();
        $this->sendClassSignUpEmail($swimmer);
        $this->sendClassFullEmail($lesson);
        $this->flashSuccess($swimmer);
    }

    public function isFull()
    {
        if ($this->getLesson()->isFull()) {
            session()->flash('danger', 'Sorry the lesson is full.');
            Log::warning('Someone tried to sign up for a lesson that is full.');

            return true;
        }

        return false;
    }

    public function getLesson(): Lesson
    {
        return Lesson::findOrFail(request()->lesson_id);
    }

    public function processPayment(Lesson $lesson)
    {
        return (new StripeCharge(
            request()->stripeToken,
            $this->applyPromoCode($lesson->price),
            request()->email,
            $lesson->group->type.' swim lessons for '.request()->firstName.' '.request()->lastName.' through The Swim School.'
        ))->charge()->id;
    }

    public function applyPromoCode(int $price)
    {
        // TODO DO PROMO CODE STUFF
        return $price;
    }

    public function subscribeToNewsLetter()
    {
        if (request()->emailUpdates == 'on') {
            NewsLetter::subscribe(request()->email);
        }
    }

    public function createSwimmer(string $chargeId)
    {
        // TODO: Logic to check the age of the swimmer against what the lesson age is
        request()->merge([
            'birthDate' => Carbon::parse(request()->birthDate),
            'stripeChargeId' => $chargeId,
        ]);

        return Swimmer::create(request()->all());
    }

    public function sendClassSignUpEmail(Swimmer $swimmer)
    {
        try {
            Mail::to($swimmer->email)->send(new SignUp($swimmer->lesson));
            Log::info("Group Lesson sign up email sent to {$swimmer->email}. Swimmer ID: {$swimmer->id} Lesson ID: {$swimmer->lesson->id}.");
        } catch (\Exception $e) {
            Log::error('Email error: ');
            Log::error(print_r($e->getMessage(), true));
        }
    }

    public function sendClassFullEmail(Lesson $lesson)
    {
        if ($lesson->isFull()) {
            try {
                foreach (config('mail.lead_dest_emails') as $email) {
                    Log::info("Sending lesson full email to {$email}. Lesson ID: {$lesson->id}");
                    Mail::to($email)->send(new ClassFull($lesson));
                }
            } catch (\Exception $e) {
                Log::error('Email error: ');
                Log::error(print_r($e->getMessage(), true));
            }
        }
    }

    public function flashSuccess(Swimmer $swimmer)
    {
        Log::info("Swimmer ID: {$swimmer->id} successfully signed up for lesson ID: {$swimmer->lesson->id}");
        session()->flash('success', "Thanks for signing up! The first lesson is {$swimmer->lesson->class_start_date->format('F jS')} at {$swimmer->lesson->class_start_time->format('g:i a')}.");
    }
}
