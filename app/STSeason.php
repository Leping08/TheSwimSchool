<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class STSeason extends Model
{
    use HasFactory;

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
