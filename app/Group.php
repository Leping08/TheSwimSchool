<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Group'
 *
 * @property int $id
 * @property string $type
 * @property string $ages
 * @property string $icon
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class Group extends Model
{
    use SoftDeletes, Actionable, HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['type', 'ages', 'description', 'icon'];

    /**
     * @var array
     */
    protected $appends = ['iconPath'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Swimmers()
    {
        return $this->hasManyThrough(\App\Swimmer::class, \App\Lesson::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->where([
            ['type', 'NOT LIKE', '%Private%'],
            ['type', 'NOT LIKE', '%Shark%'], // todo remove this in january 2023 and delete the shark group
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePrivate($query)
    {
        return $query->where('type', 'LIKE', '%Private%');
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'type';
    }

    public function getIconPathAttribute()
    {
        return "/img/sea-life/{$this->icon}";
    }
}
