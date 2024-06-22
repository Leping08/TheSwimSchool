<?php

namespace App\Nova;

use App\Nova\Metrics\LessonsPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Day extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\DaysOfTheWeek::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'day';

    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'day',
    ];

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
            Text::make('day')->sortable(),
            BelongsToMany::make('Lessons', 'lessons', Lesson::class),
            BelongsToMany::make('Swim Team Levels', 'levels', STLevel::class)->fields(function () {
                return [
                    DateTime::make('start_time'),
                    DateTime::make('end_time'),
                ];
            }),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
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
            LessonsPerDay::make()->width('full'),
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
}
