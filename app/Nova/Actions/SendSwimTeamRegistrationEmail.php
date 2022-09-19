<?php

namespace App\Nova\Actions;

use App\Mail\SwimTeam\SwimTeamCurrentSwimmerRegistration;
use App\STSwimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendSwimTeamRegistrationEmail extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (STSwimmer $sTSwimmer) {
            Log::info("Sending swim team registration email to {$sTSwimmer->firstName} {$sTSwimmer->lastName} at {$sTSwimmer->email}");
            Mail::to($sTSwimmer->email)->queue(new SwimTeamCurrentSwimmerRegistration($sTSwimmer));
            Log::info("Swim team registration email sent to {$sTSwimmer->email} for {$sTSwimmer->firstName} {$sTSwimmer->lastName}");
        });
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
