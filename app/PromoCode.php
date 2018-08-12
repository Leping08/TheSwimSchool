<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    /**
     * @return float
     */
    public function discount()
    {
        return $this->getAttribute('discount_percent') * .01;
    }
}
