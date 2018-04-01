<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * A tryout is to see if you are skilled enough for the swim team
 */

class Tryout extends Model
{

    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'registration_open', 'event_time'];

    /**
     * @var array
     */
    protected $fillable = [
        'season_id',
        'location_id',
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
     * @return mixed
     */
    public function AllTryoutsOpenForSignups()
    {
        return $this->whereDate('class_start_date', '>', Carbon::now())
                    ->whereDate('registration_open', '<=', Carbon::now());
    }


    /**
     * @return bool
     */
    public function isFull()
    {
        if($this->athletes()->count() >= $this->getAttribute('class_size')){
            return true;
        } else {
            return false;
        }
    }
}
