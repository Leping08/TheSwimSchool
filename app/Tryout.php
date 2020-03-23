<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Tryout'
 * A tryout is to see if you are skilled enough for the swim team
 *
 * @property integer $id
 * @property integer $class_size
 * @property integer $location_id
 * @property-read \App\Location $location
 * @property integer $s_t_season_id
 * @property-read \App\STSeason $season
 * @property-read \App\Athlete $athletes
 * @property \Illuminate\Support\Carbon $registration_open
 * @property \Illuminate\Support\Carbon $event_time
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */

class Tryout extends Model
{

    use SoftDeletes, Actionable;

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'registration_open', 'event_time'];

    /**
     * @var array
     */
    protected $fillable = [
        'location_id',
        's_t_season_id',
        'class_size',
        'registration_open',
        'event_time'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Athletes()
    {
        return $this->hasMany(Athlete::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Season()
    {
        return $this->belongsTo(STSeason::class, 's_t_season_id');
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeRegistrationOpen($query)
    {
        return $query->whereDate('event_time', '>', Carbon::now())
                    ->whereDate('registration_open', '<=', Carbon::now());
    }


    /**
     * @return bool
     */
    public function isFull()
    {
        return $this->athletes()->count() >= $this->class_size;
    }
}
