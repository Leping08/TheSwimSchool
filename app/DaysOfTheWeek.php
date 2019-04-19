<?php

namespace App;

use App\STLevel;
use Illuminate\Database\Eloquent\Model;

class DaysOfTheWeek extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Lessons()
    {
        return $this->belongsToMany(Lesson::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function levels()
    {
        return $this->belongsToMany(STLevel::class, 's_t_schedules')
                    ->using(STSchedule::class)
                    ->withPivot('start_time', 'end_time')
                    ->withTimestamps();
    }
}
