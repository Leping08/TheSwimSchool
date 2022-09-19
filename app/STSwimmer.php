<?php

namespace App;

use App\Library\Helpers\Ages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class STSwimmer extends Model
{
    use SoftDeletes, Ages, Actionable, HasFactory;

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'birthDate'];

    /**
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate',
        'email',
        'phone',
        'parent',
        'notes',
        'street',
        'city',
        'state',
        'zip',
        'emergencyName',
        'emergencyRelationship',
        'emergencyPhone',
        'stripeChargeId',
        's_t_level_id',
        's_t_season_id',
        'promo_code_id',
        's_t_shirt_size_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(STLevel::class, 's_t_level_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(STSeason::class, 's_t_season_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shirtSize()
    {
        return $this->belongsTo(STShirtSize::class, 's_t_shirt_size_id');
    }

    /**
     * @return float|int
     */
    public function promoAppliedPrice()
    {
        if ($this->promoCode) {
            $discount_percent = ($this->promoCode->discount_percent * .01);
            $price = $this->level->price;

            return $price - ($discount_percent * $price);
        } else {
            return $this->level->price;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function signedUpSwimmers()
    {
        return $this->belongsTo(STLevel::class, 's_t_level_id')
                    ->where('stripeChargeId', '!=', null);
    }
}
