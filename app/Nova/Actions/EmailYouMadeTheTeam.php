<?php

namespace App\Nova\Actions;

use App\Models\Athlete;
use App\Models\STLevel;
use App\Models\PromoCode;
use App\Mail\STInvitation;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
                $model->update(['s_t_sign_up_email' => 1]);     //TODO Is this needed with actions being a thing?
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
     * @return array
     */
    public function fields()
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
