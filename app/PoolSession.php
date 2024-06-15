<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'PoolSession'
 *
 * @property int $id
 * @property string $pool_session_id
 * @property string $pool_session_type
 * @property string $location_id
 * @property string $instructor_id
 * @property int $price
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Location $location
 * @property-read Instructor $instructor
 * @property-read Swimmer $swimmers
 * @property-read PoolSessionAttendance $attendances
 */
class PoolSession extends Model
{
    use HasFactory;

    protected $fillable = ['start', 'end', 'pool_session_id', 'pool_session_type', 'location_id', 'instructor_id', 'price'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function pool_sessionable()
    {
        return $this->morphTo('pool_session', 'pool_session_type', 'pool_session_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function lesson()
    {
        return $this->morphTo('lesson', 'pool_session_type', 'pool_session_id');
    }

    public function attendances()
    {
        return $this->hasMany(PoolSessionAttendance::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Scope a query to only include private pool session that are available.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePrivateLessonsAvailable($query)
    {
        return $query->where('pool_session_type', PrivateLesson::class)
                    ->whereNull('pool_session_id');
    }

    /**
    * Scope a query to only include private pool session that are available.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePrivateLessonsSignedUp($query)
    {
        return $query->where('pool_session_type', PrivateLesson::class)
                    ->whereNotNull('pool_session_id');
    }

    /**
     * Scope a query to only include private lesson pool sessions.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePrivateLessons($query)
    {
        return $query->where('pool_session_type', PrivateLesson::class);
    }

    /**
     * Scope a query to only include group lesson pool sessions.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeGroupLessons($query)
    {
        return $query->where('pool_session_type', Lesson::class);
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
