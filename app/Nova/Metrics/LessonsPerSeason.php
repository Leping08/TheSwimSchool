<?php

namespace App\Nova\Metrics;

use App\Nova\Helpers\NovaHelpers;
use App\Season;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class LessonsPerSeason extends Partition
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
        $locations = Season::withCount('lessons')->orderBy('lessons_count', 'desc')->get()->toArray();

        return $this->makePartitionResult(collect($locations), 'name', 'lessons_count');
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
        return 'lessons-per-season';
    }
}
