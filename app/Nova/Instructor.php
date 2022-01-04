<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\VaporImage;
use Laravel\Nova\Http\Requests\NovaRequest;

class Instructor extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Instructor::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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
        'name'
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
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name', 'name'),
            Boolean::make('Active', 'active'),
            Text::make('Color', 'hex_color')->onlyOnForms()->nullable()->hideFromIndex(),
            Text::make('Color', function () {
                return view('partials.color', [
                    'color' => $this->hex_color,
                    ])->render();
                })->asHtml(),
            Text::make('Image URL', 'image_url')->nullable()->hideFromIndex(),
            // VaporImage::make('Image', 'image_url')->prunable(),
            Text::make('Phone', 'phone')->nullable()->hideFromIndex(),
            Textarea::make('Bio', 'bio')->rows(3)->nullable()->hideFromIndex(),
            Text::make('Calendar', function () {
                return view('partials.link', [
                    'link' => url('/calendar/'.$this->id),
                    'text' => 'View'
                    //'new_tab' => true TODO: Add new tab option to link partial
                ])->render();
            })->asHtml()->hideFromIndex(),

            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
            DateTime::make('Deleted At')->onlyOnDetail(),
            HasMany::make('Lessons', 'lessons', Lesson::class),
            HasMany::make('Pool Sessions', 'pool_sessions', PrivatePoolSession::class),
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
