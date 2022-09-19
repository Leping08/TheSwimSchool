<?php

namespace App\Nova\Actions;

use App\Mail\SwimTeam\STInvitation;
use App\PromoCode;
use App\STLevel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class EmailYouMadeTheTeam extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

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
                $model->update(['s_t_level' => $fields->level_id]);
                Log::info("Updating Athlete ID: $model->id and adding s_t_level of $fields->level_id");

                Log::info("Sending email to Athlete ID: $model->id, Email: $model->email a you made the team email for swim school level ID: $fields->level_id");
                Mail::to($model->email)->send(new STInvitation($model, PromoCode::find($fields->promo_code_id) ?? null));

                return Action::message("Email sent to $model->email!");
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return Action::danger('An error occurred trying to send the email');
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Level', 'level_id')
                ->options(STLevel::pluck('name', 'id')),
            Select::make('Promo Code', 'promo_code_id')
                ->options(PromoCode::pluck('code', 'id')),
        ];
    }

    public function name()
    {
        return 'You Made The Team Email';
    }
}
