<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * An athlete is someone who has signed up for a tryout
 */

class Athlete extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'birthDate'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate',
        'email',
        'phone',
        'tryout_id',
        'parent',
        'notes',
        'street',
        'city',
        'state',
        'zip',
        'emergencyName',
        'emergencyRelationship',
        'emergencyPhone',
        's_t_level',
        's_t_sign_up_email',
        's_t_season_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Tryout()
    {
        return $this->belongsTo(Tryout::class);
    }

    /**
     * @return mixed
     */
    public function yearsOld()
    {
        return $this->getAttribute('birthDate')->diffInYears(Carbon::now());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(STSeason::class, 's_t_season_id');
    }

    /**
     * @return mixed
     */
    public function monthsOld()
    {
        return $this->getAttribute('birthDate')->diffInMonths(Carbon::now());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function swimTeamLevel()
    {
        return $this->belongsTo(STLevel::class, 's_t_level');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCurrentSeason($query)
    {
        return $query->where('s_t_season_id', STSeason::GetCurrentSeason()->id);
    }
}
