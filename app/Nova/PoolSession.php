<?php

namespace App\Nova;

use App\Lesson as AppLesson;
use App\PrivateLesson as AppPrivateLesson;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class PoolSession extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\PoolSession>
     */
    public static $model = \App\PoolSession::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            MorphTo::make('Pool Sessionable', 'pool_sessionable')->types([
                Lesson::class,
                PrivateLesson::class,
            ])->exceptOnForms()->searchable(),
            Select::make('Pool Sessionable Type', 'pool_session_type')->options([
                AppPrivateLesson::class => 'Private Lesson',
                AppLesson::class => 'Group Lesson',
            ])->displayUsingLabels(),
            Number::make('Pool Sessionable Id', 'pool_session_id')->hideFromIndex(),
            BelongsTo::make('Location'),
            BelongsTo::make('Instructor'),
            DateTime::make('Start'),
            DateTime::make('End'),
            HasMany::make('Attendances', 'attendances', PoolSessionAttendance::class),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
            DateTime::make('Deleted At')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public function title()
    {
        return $this->start->format('m/d h:i A');
    }
}
