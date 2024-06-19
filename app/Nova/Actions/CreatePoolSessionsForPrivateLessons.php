<?php

namespace App\Nova\Actions;

use App\DaysOfTheWeek;
use App\Instructor;
use App\Location;
use App\PrivateLesson;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
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
            DateTime::make('Start Date and Time', 'start_date_time'),
            DateTime::make('End Date and Time', 'end_date_time'),
            Number::make('Price', 'price')->default(35),
            BooleanGroup::make('Days', 'days')->options(DaysOfTheWeek::all()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['day']];
            }))->hideFalseValues()->onlyOnForms()->hideFromDetail()->hideWhenUpdating(),
            Select::make('Location', 'location_id')
                ->options(Location::all()->pluck('name', 'id'))
                ->default(63), // Realhab default
            Select::make('Instructor', 'instructor_id')
                ->options(Instructor::all()->pluck('name', 'id'))
                ->default(Auth::user()->id),
        ];
    }
}
