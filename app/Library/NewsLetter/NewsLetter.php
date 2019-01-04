<?php

namespace App\Library\NewsLetter;

use App\EmailList;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NewsLetter
{
    public static function subscribe(string $email)
    {
        if(NewsLetter::validateEmail($email)){
            try{
                EmailList::where($email, 'email')->firstOrFail();
                Log::info("{$email} was already on the email list.");
            } catch (ModelNotFoundException $exception){
                $new =  EmailList::create([
                    'email' => $email
                ]);
                Log::info("Added {$new->email} to email list.");
            }
        }
    }

    public static function unsubscribe(string $email)
    {
        try{
            $emailList = EmailList::where($email, 'email')->firstOrFail();
            $emailList->update(['subscribe' => 0]);
            Log::info("{$emailList} has unsubscribed.");
            return true;
        } catch (ModelNotFoundException $e){
            Log::info("Could not find {$email} to unsubscribe.");
            return null;
        }
    }

    public static function validateEmail(string $email) : bool
    {
        try{
            Validator::make(['email' => $email], [ 'email' => 'email'])->validate();
            return true;
        } catch (ValidationException $exception) {
            Log::info( "{$email} was not a valid email and was not added to the EmailList");
            return false;
        }
    }
}