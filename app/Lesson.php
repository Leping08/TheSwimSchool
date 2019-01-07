<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Lesson'
 *
 * @property integer $id
 * @property integer $season_id
 * @property integer $group_id
 * @property integer $location_id
 * @property integer $price
 * @property integer $class_size
 * @property \Illuminate\Support\Carbon $registration_open
 * @property \Illuminate\Support\Carbon $class_start_time
 * @property \Illuminate\Support\Carbon $class_end_time
 * @property \Illuminate\Support\Carbon $class_start_date
 * @property \Illuminate\Support\Carbon $class_end_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Group $group
 * @property-read \App\Location $location
 * @property-read \App\Season $season
 */

class Lesson extends Model
{
    use SoftDeletes, Actionable;

    /**
     * @var array
     */
    protected $dates = [
        'registration_open',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'season_id',
        'group_id',
        'location_id',
        'price',
        'registration_open',
        'class_size',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Swimmers()
    {
        return $this->hasMany(Swimmer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function DaysOfTheWeek()
    {
        return $this->belongsToMany(DaysOfTheWeek::class)->withTimestamps();
    }

    /**
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->class_size <= $this->Swimmers()->count();
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return strpos($this->group->type, 'Private') !== false;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return '/lessons/'.$this->group->type;
    }

    /**
     * @return array
     */
    public function DaysOfTheWeekArray(): array
    {
        return collect($this->DaysOfTheWeek()->get())->map(function ($item) {
            return $item->day;
        })->toArray();
    }

    /**
     * @return array
     */
    public function DaysOfTheWeekIdsArray(): array
    {
        return collect($this->DaysOfTheWeek()->get())->map(function ($item) {
            return $item->id;
        })->toArray();
    }

    /**
     * @return bool
     */
    public function hasSwimmers(): bool
    {
        return $this->Swimmers()->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function WaitList()
    {
        return $this->hasMany(WaitList::class)->orderBy('created_at', 'asc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRegistrationOpen($query)
    {
        return $query
            ->whereDate('class_start_date', '>', Carbon::yesterday())
            ->whereDate('registration_open', '<=', Carbon::now())->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStartingTomorrow($query)
    {
        return $query->where('class_start_date', Carbon::tomorrow());
    }
}
