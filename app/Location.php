<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'street', 'city', 'state', 'zip', 'phoneNumber'];

    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
