<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * An Eloquent Model: 'WaitList'
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property boolean $followed_up
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Lesson $lesson
 */

class WaitList extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'lesson_id',
        'followed_up'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
