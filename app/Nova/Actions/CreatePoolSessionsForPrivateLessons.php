<?php

namespace App\Nova\Actions;

use App\DaysOfTheWeek;
use App\Nova\Instructor;
use App\Nova\Location;
use App\PrivateLesson;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreatePoolSessionsForPrivateLessons extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Create Private Pool Sessions';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var PrivateLesson $privateLesson */
        $privateLesson = PrivateLesson::first();

        $privateLesson->generatePoolSessions(collect($fields)->toArray());

        return Action::message('Pool Sessions Created!');
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
            DateTime::make('Start Date and Time', 'start_date_time')->onlyOnForms()->hideWhenUpdating(),
            DateTime::make('End Date and Time', 'end_date_time')->onlyOnForms()->hideWhenUpdating(),
            BooleanGroup::make('Days', 'days')->options(DaysOfTheWeek::all()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['day']];
            }))->hideFalseValues()->onlyOnForms()->hideFromDetail()->hideWhenUpdating(),
            BelongsTo::make('Location', 'location', Location::class)->withMeta([
                'belongsToId' => $this->location_id ?? 63, //REALHAB location id
            ])->searchable(),
            BelongsTo::make('Instructor', 'instructor', Instructor::class),
        ];
    }
}
