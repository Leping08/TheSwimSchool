<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;


/**
 * An Eloquent Model: 'PrivateLesson'
 *
 * @property integer $id
 * @property string $season_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Season $season
 * @property-read PrivatePoolSession $pool_sessions
 * @property-read PrivateSwimmer $swimmers
 */

class PrivateLesson extends Model
{
    use SoftDeletes, Actionable, Notifiable;

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
     * @return HasMany
     */
    public function pool_sessions()
    {
        return $this->hasMany(PrivatePoolSession::class, 'private_lesson_id');
    }

    /**
     * @return HasMany
     */
    public function swimmers()
    {
        return $this->hasMany(PrivateSwimmer::class, 'private_lesson_id');
    }
}
