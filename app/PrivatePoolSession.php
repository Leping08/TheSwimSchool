<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'PrivatePoolSession'
 * TODO: Make this go away in the future and just have it be a bunch of pool sessions
 *
 * @property integer $id
 * @property string $private_lesson_id
 * @property string $location_id
 * @property string $instructor_id
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read PrivateLesson $lesson
 * @property-read PrivateSwimmer $swimmers
 * @property-read Location $location
 * @property-read User $instructor
 */

class PrivatePoolSession extends Model
{
    use SoftDeletes, Actionable, Notifiable, HasFactory;

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'start', 'end'];

    /**
     * @var array
     */
    protected $fillable = ['start', 'end', 'private_lesson_id', 'location_id', 'instructor_id'];

    /**
     * @return BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(PrivateLesson::class, 'private_lesson_id');
    }

    /**
     * @return PrivateSwimmer|null
     */
    public function swimmer()
    {
        return $this->lesson->swimmer ?? null;
    }

    /**
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * @return BelongsTo
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * If the user has swimmers then its considered full
     *
     * @return bool
     */
    public function getFullAttribute(): bool
    {
        return $this->swimmers->count() ? true : false;
    }

    /**
     * Scope a query to only include pool session being available.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereNull('private_lesson_id');
    }

    /**
     * Scope a query to only include pool session being available.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeUnavailable($query)
    {
        return $query->whereNotNull('private_lesson_id');
    }

    /**
     * Scope a query to only include pool session being available.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAfterNow($query)
    {
        return $query->whereDate('start', '>', Carbon::now());
    }

    /**
     * This  is needed for safari to parse the date time of for the private calendar
     */
    public function getStartAttribute($value)
    {
        return Carbon::parse($value);
    }

    /**
     * This  is needed for safari to parse the date time of for the private calendar
     */
    public function getEndAttribute($value)
    {
        return Carbon::parse($value);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStartingTomorrow($query)
    {
        return $query->where('start', Carbon::tomorrow());
    }

    /**
     * @param $query
     * @return mixed
     *
     * If today is after the 25th of the month then show the lessons
     * for the rest of this month and the whole next month.
     *
     * If today is before the 25th of this month then just
     * show this months lessons.
     *
     */
    public function scopeStartConditionallyNextMonth($query)
    {
        $now = Carbon::now();
        $dayNumber = $now->format('j');

        if ($dayNumber < 25) { //TODO write test for this
            return $query->whereBetween('start', [$now->toDateTimeString(), $now->endOfMonth()->toDateTimeString()]);
        } else {
            return $query->whereBetween('start', [$now->toDateTimeString(), $now->addMonth()->endOfMonth()->toDateTimeString()]);
        }
    }
}
