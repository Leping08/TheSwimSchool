<?php

namespace App\Nova;

use App\DaysOfTheWeek;
use Carbon\Carbon;
use Fourstacks\NovaCheckboxes\Checkboxes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PrivatePoolSession extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\PrivatePoolSession::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Privates';


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Custom store controller
     *
     * @param Request $request
     * @param Model   $model
     * @return Model
     */
    public static function customStoreController(Request $request, Model $model)
    {
        //TODO Write test for this
        $daysOfTheWeek = collect(json_decode($request['days']))->filter(function($value, $key) {
            return $value === true;
        })->keys();

        $dates = collect([]);

        foreach ($daysOfTheWeek as $day) {
            $carbonDayMappings = collect([
                1 => Carbon::MONDAY,
                2 => Carbon::TUESDAY,
                3 => Carbon::WEDNESDAY,
                4 => Carbon::THURSDAY,
                5 => Carbon::FRIDAY,
                6 => Carbon::SATURDAY,
                7 => Carbon::SUNDAY
            ]);

            //Parse the date and go back one day to account for the start date being accessible
            $startDate = Carbon::parse($request['start_date_time'])->subDay()->next($carbonDayMappings->get($day));
            $endDate = Carbon::parse($request['end_date_time']);

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                $dates->push(Carbon::parse($date));
            }
        }

        $startTimeString = Carbon::parse($request['start_date_time'])->toTimeString();
        $endTimeString = Carbon::parse($request['end_date_time'])->toTimeString();

        foreach ($dates as $poolSessionDate) {
            $start = Carbon::parse($poolSessionDate)->setTimeFromTimeString($startTimeString);
            $end = Carbon::parse($poolSessionDate)->setTimeFromTimeString($endTimeString);

            \App\PrivatePoolSession::create([
                'start' => $start,
                'end' => $end,
                'location_id' => $request['location'],
                'instructor_id' => $request['instructor']
            ]);
        }

        return \App\PrivatePoolSession::latest('created_at')->first();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('', function (){
                return view('partials.buttons', [
                    'next_id' => $this->model()->id + 1,
                    'previous_id' => $this->model()->id - 1
                ])->render();
            })->asHtml()->onlyOnDetail(),
            ID::make()->sortable(),
            DateTime::make('Start', 'start')->hideWhenCreating(),
            DateTime::make('End', 'end')->hideWhenCreating(),
            //Date::make('Start Date', 'start_date')->onlyOnForms()->hideWhenUpdating(),
            //Date::make('End Date', 'end_date')->onlyOnForms()->hideWhenUpdating(),
            DateTime::make('Start Date and Time', 'start_date_time')->onlyOnForms()->hideWhenUpdating(),
            DateTime::make('End Date and Time', 'end_date_time')->onlyOnForms()->hideWhenUpdating(),
            Checkboxes::make('Days', 'days')
                ->options(DaysOfTheWeek::all()->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['day']];
                }))->saveAsString()->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
            BelongsTo::make('Lesson', 'lesson', PrivateLesson::class)->nullable(),
            BelongsTo::make('Location', 'location', Location::class)->withMeta([
                //Select River Wilderness by default
                'belongsToId' => $this->location_id ?? 5
            ])->searchable(),
            BelongsTo::make('Instructor', 'instructor', User::class)->withMeta([
                //The logged in user by default
                'belongsToId' => $this->user_id ?? auth()->id()
            ])->searchable(),
            HasMany::make('Swimmers', 'swimmers', PrivateSwimmer::class),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function label()
    {
        return 'Pool Sessions';
    }
}
