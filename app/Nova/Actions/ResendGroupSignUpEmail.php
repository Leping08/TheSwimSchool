<?php

namespace App\Nova\Actions;

use App\Library\Lesson\Enroll;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class ResendGroupSignUpEmail extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Resend Sign Up Email';

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
                (new Enroll())->sendClassSignUpEmail($swimmer);
            }
        } catch (\Exception $exception) {
            return Action::danger('An error occurred trying to send the email');
        }

        return Action::message('Email sent!');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
