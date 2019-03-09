<?php

namespace App\Nova\Filters;

use App\Models\Group;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class LessonLevel extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('group_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $types = Group::pluck('type');
        $ids = Group::pluck('id');
        return $types->combine($ids);
    }

    public function name()
    {
        return "Level";
    }
}
