<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * An athlete is someone who has signed up for a tryout
 *
 * An Eloquent Model: 'Swimmer'
 *
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon $birthDate
 * @property string $parent
 * @property string $notes
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $emergencyName
 * @property string $emergencyRelationship
 * @property string $emergencyPhone
 * @property integer $tryout_id
 * @property integer $s_t_level
 * @property integer $s_t_season_id
 * @property bool $s_t_sign_up_email
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Models\Tryout $tryout
 * @property-read \App\Models\STLevel $level
 * @property-read \App\Models\STSeason $season
 *
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Season()
    {
        return $this->belongsTo(STSeason::class, 's_t_season_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Level()
    {
        return $this->belongsTo(STLevel::class, 's_t_level');
    }

    /**
     * @return mixed
     */
    public function monthsOld()
    {
        return $this->birthDate->diffInMonths(Carbon::now());
    }

    /**
     * @return mixed
     */
    public function yearsOld()
    {
        return $this->birthDate->diffInYears(Carbon::now());
    }
}
