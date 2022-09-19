<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An athlete is someone who has signed up for a tryout
 *
 * An Eloquent Model: 'Swimmer'
 *
 * @property int $id
 * @property string $hash
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
 * @property int $tryout_id
 * @property int $s_t_level
 * @property int $s_t_season_id
 * @property bool $s_t_sign_up_email
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Tryout $tryout
 * @property-read \App\STLevel $level
 * @property-read \App\STSeason $season
 */
class Athlete extends Model
{
    use SoftDeletes, Actionable, HasFactory;

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'birthDate',
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
        's_t_season_id',
        'hash',
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

    /**
     * @method static findByHash()
     *
     * @param $query
     * @param $hash
     * @return mixed
     */
    public function scopeFindByHash($query, $hash)
    {
        return $query->where('hash', '=', $hash);
    }
}
