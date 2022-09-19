<?php

namespace App\Nova;

use App\Nova\Metrics\OpenPrivateRequests;
use App\Nova\Metrics\PrivateRequestsPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class PrivateLessonRequest extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\PrivateLessonLead::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'swimmer_name';

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
        'swimmer_name',
        'email',
        'phone',
        'type',
        'length',
        'location',
        'availability',
        'address',
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
            Text::make('Swimmer Name', 'swimmer_name'),
            Text::make('Email', 'email')->onlyOnForms(),
            Text::make('Email', function () {
                return view('partials.link', [
                    'link' => 'mailto:'.$this->email,
                    'text' => $this->email,
                ])->render();
            })->asHtml(),
            Text::make('Phone', 'phone')->onlyOnForms(),
            Text::make('Phone', function () {
                return view('partials.link', [
                    'link' => 'tel:1'.$this->phone,
                    'text' => $this->phone,
                ])->render();
            })->asHtml(),
            Text::make('Age', function () {
                return view('partials.age', [
                    'birthDate' => $this->swimmer_birth_date,
                ])->render();
            })->hideFromIndex(),
            Text::make('Type', 'type')->hideFromIndex(),
            Text::make('Length', 'length')->hideFromIndex(),
            Text::make('Location', 'location')->hideFromIndex(),
            Boolean::make('Harrison Ranch resident', 'hr_resident')->hideFromIndex(),
            Text::make('Address', 'address')->hideFromIndex(),
            Text::make('Availability', 'availability')->hideFromIndex(),
            Boolean::make('Followed Up', 'followed_up')->sortable(),
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
            (new PrivateRequestsPerDay())->width('2/3'),
            (new OpenPrivateRequests())->width('1/3'),
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

    public static function label()
    {
        return 'Requests';
    }
}
