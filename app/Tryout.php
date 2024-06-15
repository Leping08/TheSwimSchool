<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Tryout'
 * A tryout is to see if you are skilled enough for the swim team
 *
 * @property int $id
 * @property int $class_size
 * @property int $location_id
 * @property-read \App\Location $location
 * @property int $s_t_season_id
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
    use SoftDeletes, Actionable, HasFactory;

    /**
     * @var array
     */
    protected $casts = [
        'class_size' => 'integer',
        'location_id' => 'integer',
        's_t_season_id' => 'integer',
        'registration_open' => 'datetime',
        'event_time' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'location_id',
        's_t_season_id',
        'class_size',
        'registration_open',
        'event_time',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function athletes()
    {
        return $this->hasMany(Athlete::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
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
