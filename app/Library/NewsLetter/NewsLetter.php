<?php

namespace App\Library\NewsLetter;

use App\Models\EmailList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsLetter
{
    /**
     * @param string $email
     * @return bool|EmailList
     */
    public static function subscribe(string $email)
    {
        if (self::validateEmail($email)) {
            try {
                //They are already on the email list
                $emailList = EmailList::where('email', $email)->firstOrFail();
                Log::info("{$emailList->email} was already on the email list.");
                //They want to resubscribe
                if ($emailList->subscribe = false) {
                    $emailList->resubscribe();
                    Log::info("{$emailList->email} resubscribed to the email list.");
                }

                return $emailList;
            } catch (ModelNotFoundException $exception) {
                //New email to add to the email list
                $emailList = EmailList::create([
                    'email' => $email,
                    'subscribe' => 1,
                ]);
                Log::info("Added {$emailList->email} to email list.");

                return $emailList;
            }
        } else {
            Log::info('Something went wrong trying to add {$email} to the email list');

            return false;
        }
    }

    /**
     * @param string $email
     * @return bool|null
     */
    public static function unsubscribe(string $email)
    {
        try {
            $emailList = EmailList::where($email, 'email')->firstOrFail();
            $emailList->update(['subscribe' => 0]);
            Log::info("{$emailList} has unsubscribed.");

            return true;
        } catch (ModelNotFoundException $e) {
            Log::info("Could not find {$email} to unsubscribe.");

            return;
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function validateEmail(string $email) : bool
    {
        try {
            Validator::make(['email' => $email], ['email' => 'email'])->validate();

            return true;
        } catch (ValidationException $exception) {
            Log::info("{$email} was not a valid email and was not added to the EmailList");

            return false;
        }
    }
}
