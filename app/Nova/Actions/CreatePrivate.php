<?php

namespace App\Nova\Actions;

use App\DaysOfTheWeek;
use App\Nova\Instructor;
use App\Nova\Location;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreatePrivate extends Action
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
        // $days = ["1" => true,"2" => true,"3" => true,"4" => false,"5" => false,"6" => false,"7" => false];
        $daysOfTheWeekId = collect($fields->days)->filter(function ($value, $key) {
            return $value === true;
        })->keys()->toArray();
        $dates = collect();

        foreach ($daysOfTheWeekId as $dayId) {
            $carbonDayMappings = collect([
                1 => Carbon::MONDAY,
                2 => Carbon::TUESDAY,
                3 => Carbon::WEDNESDAY,
                4 => Carbon::THURSDAY,
                5 => Carbon::FRIDAY,
                6 => Carbon::SATURDAY,
                7 => Carbon::SUNDAY,
            ]);

            //Parse the date and go back one day to account for the start date being accessible
            $startDate = Carbon::parse($fields->start_date_time)->subDay()->next($carbonDayMappings->get($dayId));
            $endDate = Carbon::parse($fields->end_date_time);

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                $dates->push(Carbon::parse($date));
            }
        }

        $startTimeString = Carbon::parse($fields->start_date_time)->toTimeString();
        $endTimeString = Carbon::parse($fields->end_date_time)->toTimeString();

        foreach ($dates as $poolSessionDate) {
            $start = Carbon::parse($poolSessionDate)->setTimeFromTimeString($startTimeString);
            $end = Carbon::parse($poolSessionDate)->setTimeFromTimeString($endTimeString);

            \App\PrivatePoolSession::create([
                'start' => $start,
                'end' => $end,
                'location_id' => $fields->location->id,
                'instructor_id' => $fields->instructor->id,
            ]);
        }

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
