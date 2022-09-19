<?php

namespace App\Nova\Metrics;

use App\PrivateLessonLead;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class OpenPrivateRequests extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->result(PrivateLessonLead::where('followed_up', false)->count());
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'open-private-requests';
    }

    public function name()
    {
        return 'Privates Not Followed Up';
    }
}
