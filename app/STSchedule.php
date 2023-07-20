<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class STSchedule extends Pivot
{
    protected $fillable = [
        'start_time',
        'end_time',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'end_time' => 'datetime',
        'start_time' => 'datetime',
    ];

    protected $table = ['s_t_schedules'];
}
