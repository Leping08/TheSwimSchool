<?php

namespace App\Nova\Metrics;

use App\Lesson;
use App\Location;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class LessonsPerLocation extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, Lesson::class, 'location_id')
            ->label(function ($value){
                $location = Location::find($value);
                return "$location->name";
            });
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
        return 'lessons-per-location';
    }
}
