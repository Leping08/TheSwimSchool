<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class STLevel extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schedule()
    {
        return $this->belongsToMany(DaysOfTheWeek::class, 's_t_schedules')->withPivot('start_time', 'end_time')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function swimmers()
    {
        return $this->hasMany(STSwimmer::class)
                    ->where('s_t_swimmers.stripeChargeId', '!=', null);
    }
}
