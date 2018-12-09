<?php

namespace App\Nova\Actions;

use App\Mail\LessonLink;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\Text;

class EmailLessonLink extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $name = "Email Lesson Link";

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            try {
                Mail::to($fields->email)->send(new LessonLink($model));
                Log::info("Sending lesson sign up link email to $fields->email");
                return Action::message("Email sent to $fields->email!");
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return Action::danger("An error occurred trying to send the email");
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Email Address', 'email'),
        ];
    }
}
