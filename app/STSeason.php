<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class STSeason extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function swimmers()
    {
        return $this->hasMany(STSwimmer::class)->where('s_t_swimmers.stripeChargeId', '!=', null);
    }
}
