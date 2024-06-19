<?php

namespace App\Nova\Metrics;

use App\Location;
use App\Nova\Helpers\NovaHelpers;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class LessonsPerLocation extends Partition
{
    use NovaHelpers;

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $locations = Location::withCount('lessons')->orderBy('lessons_count', 'desc')->get();

        return $this->makePartitionResult($locations, 'name', 'lessons_count');
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int
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
        return 'lessons-per-location';
    }
}
