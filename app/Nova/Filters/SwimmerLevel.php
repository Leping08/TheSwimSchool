<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class SwimmerLevel extends Filter
{
    public function apply(Request $request, $query, $value)
    {
        return $query->select('swimmers.*')
            ->join('lessons', 'lessons.id', '=', 'swimmers.lesson_id')
            ->where('group_id', $value)
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

        foreach (\App\Models\Group::all() as $group) {
            $result->put($group->type, $group->id);
        }

        return $result;
    }

    public function name()
    {
        return 'Level';
    }
}
