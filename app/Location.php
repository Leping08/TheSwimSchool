<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'street', 'city', 'state', 'zip', 'phoneNumber'];

    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
