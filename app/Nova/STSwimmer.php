<?php

namespace App\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use App\Nova\Filters\ShirtSize;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\SwimTeamLevel;
use App\Nova\Filters\SwimTeamSeason;
use Laravel\Nova\Http\Requests\NovaRequest;

class STSwimmer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\STSwimmer::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'firstName',
        'lastName',
        'email',
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
            Text::make('Email', 'email')->onlyOnForms(),
            Text::make('Email', function () {
                return view('partials.link', [
                    'link' => 'mailto:'.$this->email,
                    'text' => $this->email,
                ])->render();
            })->asHtml()->sortable()->hideFromIndex(),
            Text::make('Phone', 'phone')->onlyOnForms(),
            Text::make('Phone', function () {
                return view('partials.link', [
                    'link' => 'tel:1'.$this->phone,
                    'text' => $this->phone,
                ])->render();
            })->asHtml()->hideFromIndex(),
            Date::make('Date of Birth', 'birthDate')->hideFromIndex(),
            Text::make('Parent', 'parent')->hideFromIndex(),
            Text::make('Age', function () {
                return view('partials.age', [
                    'birthDate' => $this->birthDate,
                ])->render();
            })->hideFromIndex(),
            BelongsTo::make('Level', 'level', STLevel::class),
            BelongsTo::make('Season', 'season', STSeason::class),
            BelongsTo::make('Shirt Size', 'shirtSize', STShirtSize::class),
            Text::make('Charge Id', function () {
                return view('partials.link', [
                    'link' => config('nova.path').'/nova-stripe/charge/'.$this->stripeChargeId,
                    'text' => $this->stripeChargeId,
                ])->render();
            })->asHtml()->hideFromIndex(),
            (new Panel('Emergency Contact', $this->emergencyContact())),
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
        //TODO: Add cards
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
        return [
            new SwimTeamSeason(),
            new SwimTeamLevel(),
            new ShirtSize(),
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
        return [];
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
            Text::make('Phone', 'emergencyPhone')->hideFromIndex(),
        ];
    }

    public static function label()
    {
        return 'Swimmers';
    }

    public static function uriKey()
    {
        return 'roster';
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return "$this->firstName $this->lastName";
    }
}
