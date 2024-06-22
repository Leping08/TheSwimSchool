<?php

namespace App\Nova\Lenses;

use App\Nova\Filters\SwimTeamLevel;
use App\Nova\Filters\SwimTeamSeason;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;

class Roster extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->with(['level', 'season'])
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID', 'id')->sortable(),
            Text::make('Name', function () {
                return "$this->firstName $this->lastName";
            }),
            //Text::make('Email', 'email'),
            Text::make('Phone', 'phone'),
            Date::make('Years Old', function () {
                return now()->diffInYears($this->birthDate);
            }),
            Text::make('Emergency Name', 'emergencyName'),
            Text::make('Emergency Phone', 'emergencyPhone'),
            Text::make('Level', 'level.name'),
            Text::make('Season', 'season.name'),
        ];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            SwimTeamSeason::make(),
            SwimTeamLevel::make(),
        ];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'swim-team-roster';
    }
}
