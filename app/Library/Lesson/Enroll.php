<?php

namespace App\Library\Lesson;

use App\Lesson;
use App\Library\NewsLetter\NewsLetter;
use App\Mail\Admin\ClassFull;
use App\Mail\Groups\SignUp;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Enroll a swimmer in a group lesson after their payment has succeeded.
 *
 *** Validate data                        - separate class Laravel FormRequest
 *** Check if lesson is full and process the payment - Groups\SwimmerController
 *** Create the swimmer
 *** Subscribe to news letter             - separate class NewsLetter::subscribe($email)
 *** Send class sign up email
 *** Send class full email to admin       - separate class
 * Flash success
 */
class Enroll
{
    /**
     * @param  array<string, mixed>  $swimmerData  Validated LessonSignUp data
     */
    public function handle(array $swimmerData, Lesson $lesson, string $paymentIntentId): Swimmer
    {
        $swimmer = $this->createSwimmer($swimmerData, $paymentIntentId);
        $this->subscribeToNewsLetter($swimmerData);
        $this->sendClassSignUpEmail($swimmer);
        $this->sendClassFullEmail($lesson);
        $this->flashSuccess($swimmer);

        return $swimmer;
    }

    /**
     * @param  array<string, mixed>  $swimmerData
     */
    public function createSwimmer(array $swimmerData, string $paymentIntentId): Swimmer
    {
        // TODO: Logic to check the age of the swimmer against what the lesson age is
        return Swimmer::create([
            ...Arr::except($swimmerData, ['payment_method', 'emailUpdates']),
            'birthDate' => Carbon::parse($swimmerData['birthDate']),
            'stripeChargeId' => $paymentIntentId,
        ]);
    }

    /**
     * @param  array<string, mixed>  $swimmerData
     */
    public function subscribeToNewsLetter(array $swimmerData): void
    {
        if (($swimmerData['emailUpdates'] ?? null) == 'on') {
            NewsLetter::subscribe($swimmerData['email']);
        }
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
