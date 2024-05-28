<?php

namespace App\Nova;

use App\Nova\Actions\CreatePoolSessionsForPrivateLessons;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class PrivateLesson extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\PrivateLesson::class;

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
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('', function () {
                return view('partials.buttons', [
                    'next_id' => $this->model()->id + 1,
                    'previous_id' => $this->model()->id - 1,
                ])->render();
            })->asHtml()->onlyOnDetail(),
            ID::make()->sortable(),
            // BelongsTo::make('Season', 'season', Season::class),
            // HasMany::make('Pool Sessions', 'pool_sessions', PrivatePoolSession::class),
            // @todo add attendances
            // @todo fix the pool sessions relationship
            Text::make('Text Message Link', function () {
                return view('partials.swimmers_sms_link', [
                    'swimmers_phone_numbers_string' => $this->swimmers->pluck('phone')->map(function ($phone_number) {
                        // Remove the - from the phone number
                        return '+1' . str_replace('-', '', $phone_number);
                    })->implode(',')
                ])->render();
            })->asHtml()->onlyOnDetail(),
            HasOne::make('Swimmer', 'swimmer', PrivateSwimmer::class),
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
        return [new CreatePoolSessionsForPrivateLessons()];
    }

    public static function label()
    {
        return 'Private Lessons';
    }
}
