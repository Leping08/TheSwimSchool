<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Instructor'
 *
 * @property int $id
 * @property string $name
 * @property string $bio
 * @property string $hex_color
 * @property string $image_url
 * @property string $phone
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Lesson $lessons
 * @property-read PoolSession $poolSessions
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

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if ($model->image_url && App::environment() != 'testing') {
                $disk = Storage::disk('s3');
                $disk->setVisibility($model->image_url, 'public');
            }
        });

        self::updated(function ($model) {
            if ($model->image_url && App::environment() != 'testing') {
                $disk = Storage::disk('s3');
                $disk->setVisibility($model->image_url, 'public');
            }
        });
    }

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
    public function pool_sessions()
    {
        return $this->hasMany(PoolSession::class);
    }
}
