<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * The people who have contacted site admins
 *
 * An Eloquent Model: 'Promo Code'
 *
 * @property integer $id
 * @property string $code
 * @property int $discount_percent
 * @property int $discount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 */

class PromoCode extends Model
{
    use SoftDeletes;

    /**
     * @return float
     */
    public function discount()
    {
        return $this->getAttribute('discount_percent') * .01;
    }

    public function apply(int $price)
    {
        return $price - ($price * ($this->discount_percent * 0.01));
    }
}
