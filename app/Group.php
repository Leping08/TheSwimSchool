<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['type', 'ages', 'description'];

    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
