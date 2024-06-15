<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Location'
 *
 * @property int $id
 * @property string $name
 * @property string $street
 * @property string $state
 * @property string $city
 * @property string $zip
 * @property string $pool_access_instructions
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class Location extends Model
{
    use SoftDeletes, Actionable, HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'street', 'city', 'state', 'zip'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function tryouts()
    {
        $this->hasMany(Tryout::class);
    }
}
