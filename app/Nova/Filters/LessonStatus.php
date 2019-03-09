<?php

namespace App\Nova\Filters;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class LessonStatus extends Filter
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
        if ($value === 'open-signups') {
            return $query->whereDate('class_start_date', '>', Carbon::yesterday())
                         ->whereDate('registration_open', '<=', Carbon::now());
        }

        if ($value === 'active') {
            return $query->whereDate('class_end_date', '>=', Carbon::now())   // 9/15
                         ->whereDate('class_start_date', '<=', Carbon::now()); // 8/25
        }

        if ($value === 'complete') {
            return $query->whereDate('class_end_date', '<=', Carbon::yesterday());
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            "Open for Signup" => 'open-signups',
            "Active" => 'active',
            "Complete" => 'complete'

        ];
    }

    public function name()
    {
        return "Status";
    }
}
