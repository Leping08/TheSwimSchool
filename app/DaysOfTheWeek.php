<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaysOfTheWeek extends Model
{
    public function Lessons()
    {
        return $this->belongsToMany(Lessons::class);
    }
}
