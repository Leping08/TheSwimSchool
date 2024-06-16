<?php

namespace App\Library\NewsLetter;

use App\EmailList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NewsLetter
{
    /**
     * @param  string  $email
     * @return bool|EmailList
     */
    public static function subscribe(string $email)
    {
        if (NewsLetter::validateEmail($email)) {
            try {
                //They are already on the email list
                $emailList = EmailList::where('email', $email)->firstOrFail();
                Log::info("{$emailList->email} was already on the email list.");
                //They want to resubscribe
                if ($emailList->subscribe === false) {
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
     * @param  string  $email
     * @return bool|null
     */
    public static function unsubscribe(string $email)
    {
        try {
            $emailList = EmailList::where('email', trim($email))->firstOrFail();
            $emailList->update(['subscribe' => 0]);
            Log::info("{$emailList} has unsubscribed.");

            return true;
        } catch (ModelNotFoundException $e) {
            Log::info("Could not find {$email} to unsubscribe.");

            return null;
        }
    }

    /**
     * @param  string  $email
     * @return bool
     */
    public static function validateEmail(string $email): bool
    {
        try {
            Validator::make(['email' => $email], ['email' => 'email'])->validate();

            return true;
        } catch (ValidationException $exception) {
            Log::info("{$email} was not a valid email and was not added to the EmailList");

            return false;
        }
    }

    /**
     * @return void
     */
    public static function cleanUpBotEmails()
    {
        // Get all the emails that are not deleted
        $newsLetterEmails = EmailList::all();

        // Loop through the emails
        foreach ($newsLetterEmails as $newsLetterEmail) {
            // Check if the email is a bot
            if (NewsLetter::isBotEmail($newsLetterEmail)) {
                // Log the email in the logs
                Log::info("{$newsLetterEmail->email} is a bot email and is being deleted.");
                // Unsubscribe the email
                $newsLetterEmail->delete();
            }
        }
    }

    /**
     * @param  EmailList  $email
     * @return bool
     */
    public static function isBotEmail(EmailList $emailList): bool
    {
        // Check if the email is has a capital after the @ sympbol
        $emailParts = explode('@', $emailList->email);
        if (preg_match('/[A-Z]/', $emailParts[1])) {
            return true;
        }

        return false;
    }
}
