<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Athlete extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Athlete';

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
            Text::make('First Name', 'firstName')->sortable(),
            Text::make('Last Name', 'lastName')->sortable(),
            Text::make('Email', function () {
                return view('partials.link', [
                    'link' => 'mailto:'.$this->email,
                    'text' => $this->email
                ])->render();
            })->asHtml()->sortable()->hideFromIndex(),
            Text::make('Phone', function () {
                return view('partials.link', [
                    'link' => 'tel:1'.$this->phone,
                    'text' => $this->phone
                ])->render();
            })->asHtml()->hideFromIndex(),
            Date::make('Date of Birth', 'birthDate')->hideFromIndex(),
            Text::make('Parent', 'parent')->hideFromIndex(),
            Text::make('Age', function () {
                return view('partials.age', [
                    'birthDate' => $this->birthDate
                ])->render();
            })->hideFromIndex(),
            BelongsTo::make('Tryout'),
            BelongsTo::make('Level', 'level', STLevel::class),
            BelongsTo::make('Season', 'season', STSeason::class),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
            (new Panel('Address', $this->addressFields())),
            (new Panel('Emergency Contact', $this->emergencyContact())),
            (new Panel('Notes', $this->notes())),
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

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function addressFields()
    {
        return [
            Place::make('Address', 'street')->hideFromIndex(),
            Text::make('City', 'city')->hideFromIndex(),
            Text::make('State', 'state')->hideFromIndex(),
            Text::make('Postal Code', 'zip')->hideFromIndex(),
            Text::make('Country', function () {
                return 'US';
            })->hideFromIndex()
            //Country::make('Country')->hideFromIndex(),
        ];
    }


    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function emergencyContact()
    {
        return [
            Text::make('Name', 'emergencyName')->hideFromIndex(),
            Text::make('Relationship', 'emergencyRelationship')->hideFromIndex(),
            Text::make('Phone', 'emergencyPhone')->hideFromIndex()
        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function notes()
    {
        return [
            Text::make('Notes', 'notes')->hideFromIndex(),
        ];
    }
}
