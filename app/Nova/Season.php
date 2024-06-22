<?php

namespace App\Nova;

use App\Nova\Metrics\LessonsPerSeason;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Season extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Season::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Groups';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'year',
        'season',
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
            Text::make('Year', 'year')->sortable(),
            Text::make('Season', 'season')->sortable(),
            HasMany::make('Lessons', 'lessons', Lesson::class),
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
            LessonsPerSeason::make()->width('full'),
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

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return "$this->year $this->season";
    }
}
