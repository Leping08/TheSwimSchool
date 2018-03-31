<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
