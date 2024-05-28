<?php

namespace App\Nova;

use App\Nova\Actions\ResendPrivateSignUpEmail;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

class PrivateSwimmer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\PrivateSwimmer::class;

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
        'first_name',
        'last_name',
        'email',
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
            Text::make('First Name', 'first_name')->sortable(),
            Text::make('Last Name', 'last_name')->sortable(),
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
            Date::make('Date of Birth', 'birth_date')->hideFromIndex(),
            Text::make('Parent', 'parent')->hideFromIndex(),
            Text::make('Age', function () {
                return view('partials.age', [
                    'birthDate' => $this->birth_date,
                ])->render();
            })->hideFromIndex(),
            BelongsTo::make('Lesson', 'lesson', PrivateLesson::class),
            (new Panel('Payment Info', $this->paymentInfo())),
            (new Panel('Address', $this->addressFields())),
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
        return [
            new ResendPrivateSignUpEmail(),
        ];
    }

    public static function label()
    {
        return 'Private Swimmers';
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function emergencyContact()
    {
        return [
            Text::make('Name', 'emergency_name')->hideFromIndex(),
            Text::make('Relationship', 'emergency_relationship')->hideFromIndex(),
            Text::make('Phone', 'emergency_phone')->onlyOnForms(),
            Text::make('Phone', function () {
                return view('partials.link', [
                    'link' => 'tel:1'.$this->emergency_phone,
                    'text' => $this->emergency_phone,
                ])->render();
            })->asHtml()->hideFromIndex(),
        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function paymentInfo()
    {
        return [
            Text::make('Charge Id', 'stripe_charge_id')->hideFromIndex(),
        ];
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
            })->hideFromIndex(),
        ];
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return "$this->first_name $this->last_name";
    }
}
