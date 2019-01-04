<?php

namespace App\Library\Lesson;

use App\Http\Requests\LessonSignUp;
use App\Lesson;
use Illuminate\Http\Request;

/**
 * Validate data                        - separate class Laravel FormRequest
 * Check if lesson if full              - separate class lesson->isFull()
 * Process the payment                  - separate class (new StripeCharge($token, $price, $email, $description))->pay()
 *     Promo code logic                 - separate class ??????
 * Create the swimmer
 * Subscribe to news letter             - separate class
 * Send class sign up email
 * Send class full email to admin       - separate class
 * Flash success
 * Redirect back to lesson they signed up for
 */

class SignUp
{
    /**
     *
     */
    public function handle()
    {
        (new LessonSignUp)->validated();
        $this->abortIfFull();


    }


    public function abortIfFull()
    {
        if($this->getLesson()->isFull()){
            session()->flash('danger', 'Sorry the lesson is full.');
            Log::warning("Someone tried to sign up for a lesson that is full.");
            return back();
        }
    }


    public function getLesson() : Lesson
    {
        return Lesson::findOrFail($this->request()->lesson_id);
    }

    /**
     *
     */
    public function validate()
    {

    }

    /**
     *
     */
    public function processPayment()
    {
        
    }
}