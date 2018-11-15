<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SwimmerSeason extends Filter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->select('swimmers.*')
            ->join('lessons', 'lessons.id', '=', 'swimmers.lesson_id')
            ->where('season_id', $value)
            ->get();
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $result = collect([]);

        foreach (\App\Season::all() as $season){
            $result->put($season->name(), $season->id);
        }

        return $result;
    }

    public function name()
    {
        return "Season";
    }
}
