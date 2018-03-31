<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaysOfTheWeek extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Lessons()
    {
        return $this->belongsToMany(Lessons::class)->withTimestamps();
    }
}
