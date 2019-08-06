<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class STSeason extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function swimmers()
    {
        return $this->hasMany(STSwimmer::class)
                    ->where('s_t_swimmers.stripeChargeId', '!=', null);
        //->currentseason();
    }

    public function tryouts()
    {
        return $this->hasMany(Tryout::class);
    }

    public function athletes()
    {
        return $this->hasMany(Athlete::class);
    }

    public function scopeCurrentSeason($query)
    {
        return $query->where('current_season', true)->first();
    }
}
