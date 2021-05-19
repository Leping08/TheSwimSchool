<?php

namespace App\Nova\Actions;

use App\Mail\Privates\PrivateLessonSignUp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ResendPrivateSignUpEmail extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = "Resend Sign Up Email";

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $swimmers
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $swimmers)
    {
        try {
            foreach ($swimmers as $swimmer) {
                Mail::to($swimmer->email)->send(new PrivateLessonSignUp($swimmer->lesson));
            }
        } catch (\Exception $exception) {
            return Action::danger("An error occurred trying to send the email");
        }
        return Action::message("Email sent!");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
