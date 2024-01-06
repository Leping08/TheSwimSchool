<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'PrivateLesson'
 *
 * @property int $id
 * @property string $season_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Season $season
 * @property-read PrivatePoolSession $pool_sessions
 * @property-read PrivateSwimmer $swimmer
 */
class PrivateLesson extends Model
{
    use SoftDeletes, Actionable, Notifiable, HasFactory;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['season_id'];

    /**
     * @return BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function pool_sessions()
    {
        return $this->morphMany(PoolSession::class, 'pool_sessionable');
    }

    /**
     * @return HasOne
     */
    public function swimmer()
    {
        return $this->hasOne(PrivateSwimmer::class);
    }
}
