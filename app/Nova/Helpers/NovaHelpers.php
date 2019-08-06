<?php

namespace App\Nova\Helpers;

use Illuminate\Support\Collection;

trait NovaHelpers
{
    public function makePartitionResult(Collection $collection, $first, $second)
    {
        $result = collect([]);

        foreach ($collection as $item) {
            $result->put($item[$first], $item[$second]);
        }

        return new \Laravel\Nova\Metrics\PartitionResult($result->take(10)->toArray());
    }
}
