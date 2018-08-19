<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class STSeason extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function swimmers()
    {
        return $this->hasMany(STSwimmer::class)
                    ->where('s_t_swimmers.stripeChargeId', '!=', null)
                    ->currentseason();
    }

    public function scopeGetCurrentSeason($query)
    {
        return $query->where('current_season', true)->first();
    }
}
