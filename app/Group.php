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
    public function OpenSignUps()   //TODO Make this a query scope on the lesson model and find the uses in blade files
    {
        return $this->hasMany(Lesson::class)
            ->whereDate('class_start_date', '>', Carbon::yesterday())
            ->whereDate('registration_open', '<=', Carbon::now());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Swimmers()
    {
        return $this->hasManyThrough('App\Swimmer', 'App\Lesson');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->where('type', 'NOT LIKE', '%Private%')->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePrivate($query)
    {
        return $query->where('type', 'LIKE', '%Private%')->get();
    }
}
