<?php

namespace App\Nova;

use App\DaysOfTheWeek;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use App\Nova\Metrics\NewLessons;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Leping\LessonLink\LessonLink;
use App\Nova\Filters\LessonStatus;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Actions\EmailLessonLink;
use App\Nova\Metrics\LessonsPerLevel;
use App\Library\Helpers\SeasonHelpers;
use Laravel\Nova\Fields\BelongsToMany;
use Fourstacks\NovaCheckboxes\Checkboxes;
use Laravel\Nova\Http\Requests\NovaRequest;

class Lesson extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Lesson::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    //public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Level', 'group'),
            BelongsTo::make('Season')->withMeta([
                //Get the current season
                'belongsToId' =>   $this->season_id ?? SeasonHelpers::currentSeason()->id,
            ]),
            BelongsTo::make('Location')->withMeta([
                //Select Harrison Ranch by default
                'belongsToId' => $this->location_id ?? 1,
            ]),
            Checkboxes::make('Days', 'days')
                ->options(DaysOfTheWeek::all()->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['day']];
                }))->saveAsString()->hideFromIndex()->hideFromDetail()->hideWhenUpdating(),
            LessonLink::make('Link')->onlyOnDetail(),
            Currency::make('Price')->format('$%.2n')->hideFromIndex(),
            Text::make('Class Size', 'class_size')->withMeta([
                'value' => $this->class_size ?? '4',
            ])->hideFromIndex(),
            Number::make('Spots Remaining', function () {
                return $this->class_size - $this->swimmers->count();
            }),
            Date::make('Registration Open', 'registration_open')->hideFromIndex(),
            Date::make('Start Date', 'class_start_date')->hideFromIndex(),
            Date::make('End Date', 'class_end_date')->hideFromIndex(),
            DateTime::make('Start Time', 'class_start_time')->hideFromIndex(),
            DateTime::make('End Time', 'class_end_time')->hideFromIndex(),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
            BelongsToMany::make('Days', 'DaysOfTheWeek', Day::class),
            HasMany::make('Swimmers', 'swimmers', Swimmer::class),
            HasMany::make('Wait List', 'WaitList', WaitList::class),
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
        return [
            (new LessonsPerLevel)->width('2/3'),
            (new NewLessons)->width('1/3'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\LessonStatus,
            new Filters\LessonLevel,
            new Filters\Season,
        ];
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
        return [
            new EmailLessonLink(),
        ];
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->group->type;
    }
}
