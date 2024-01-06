<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'PoolSession'
 *
 * @property int $id
 * @property string $location_id
 * @property string $instructor_id
 * @property string $pool_session_type
 * @property int $pool_session_type_id
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
class PoolSession extends Model
{
    use HasFactory, SoftDeletes, Actionable;

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'start',
        'end'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'start',
        'end',
        'private_lesson_id',
        'location_id',
        'instructor_id'
    ];

    /**
     * @return BelongsTo
     */
    public function pool_sessionable()
    {
        return $this->morphTo();
    }

    /**
     * @return PrivateSwimmer|null
     */
    public function swimmers()
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
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function attendance()
    {
        return $this->hasMany(PoolSessionAttendance::class);
    }
}
