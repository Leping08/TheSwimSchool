<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
