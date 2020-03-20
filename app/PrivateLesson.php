<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;

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
