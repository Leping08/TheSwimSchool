<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * The people who have contacted site admins.
 *
 * An Eloquent Model: 'Promo Code'
 *
 * @property int $id
 * @property string $code
 * @property int $discount_percent
 * @property int $discount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class PromoCode extends Model
{
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
