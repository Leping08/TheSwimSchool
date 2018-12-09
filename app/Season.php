<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }


    public function name()
    {
        return $this->getAttribute('year') . " " . $this->getAttribute('season');
    }

    /**
     * Get the season name.
     *
     * @return string
     */
    public function getNameAttribute() : string
    {
        return $this->year . " " . $this->season;
    }
}
