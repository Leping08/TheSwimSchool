<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * An Eloquent Model: 'Group'
 *
 * @property integer $id
 * @property string $type
 * @property string $ages
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */

class Group extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['type', 'ages', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function OpenSignUps()
    {
        return $this->hasMany(Lesson::class)
            ->whereDate('class_start_date', '>', Carbon::yesterday())
            ->whereDate('registration_open', '<=', Carbon::now());
    }

    public function swimmers()
    {
        return $this->hasManyThrough('Swimmer', 'Lesson');
    }
}
