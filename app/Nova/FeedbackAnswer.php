<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

class FeedbackAnswer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\FeedbackAnswer::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Groups';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * @var array
     */
    public static $with = [
        'question'
    ];

    /**
     * @var int
     */
    public static $perPageViaRelationship = 25;

    /**
     * @var bool
     */
    public static $displayInNavigation = false;

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
            Text::make('Question', function (){
                return $this->question->question ?? null;
            }),
            Text::make('Answer', function (){
                return Str::limit($this->answer, 50,'....');
            })->onlyOnIndex(),
            Text::make('Answer', 'answer')->hideFromIndex(),
            BelongsTo::make('Survey', 'survey', \App\Nova\FeedbackSurvey::class),
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
}
