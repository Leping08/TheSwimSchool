<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Instructor'
 *
 * @property integer $id
 * @property string $name
 * @property string $bio
 * @property string $hex_color
 * @property string $image_url
 * @property string $phone
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Lesson $lessons
 * @property-read PrivatePoolSession $privatePoolSessions
 */

class Instructor extends Model
{
    use HasFactory, SoftDeletes, Actionable;

    protected $fillable = [
        'name',
        'bio',
        'hex_color',
        'image_url',
        'phone',
        'active',
    ];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function privatePoolSessions()
    {
        return $this->hasMany(PrivatePoolSession::class);
    }

}
