<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use App\Nova\Metrics\OpenContactUs;
use App\Nova\Metrics\ContactUsPerDay;
use Laravel\Nova\Http\Requests\NovaRequest;

class ContactUs extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contact::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'email',
        'phone',
        'message',
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
            Text::make('Name', 'name'),
            Text::make('Email', 'email')->onlyOnForms(),
            Text::make('Email', function () {
                return view('partials.link', [
                    'link' => 'mailto:'.$this->email,
                    'text' => $this->email,
                ])->render();
            })->asHtml()->sortable(),
            Text::make('Phone', 'phone')->onlyOnForms(),
            Text::make('Phone', function () {
                return view('partials.link', [
                    'link' => 'tel:1'.$this->phone,
                    'text' => $this->phone,
                ])->render();
            })->asHtml(),
            Boolean::make('Followed Up', 'followed_up')->sortable(),
            Text::make('Message', 'message')->hideFromIndex(),
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
            (new ContactUsPerDay())->width('2/3'),
            (new OpenContactUs())->width('1/3'),
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
        return 'Contact Us';
    }
}
