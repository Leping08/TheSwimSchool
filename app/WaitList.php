<?php

namespace App;

use App\Library\Helpers\Ages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'WaitList'
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon date_of_birth
 * @property bool $followed_up
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Lesson $lesson
 */
class WaitList extends Model
{
    use SoftDeletes, Ages, Actionable;

    /**
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'lesson_id',
        'followed_up',
        'date_of_birth',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
