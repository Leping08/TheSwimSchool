<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $dates = [
        'registration_open',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
    ];

    protected $fillable = [
        'season_id',
        'group_id',
        'location_id',
        'price',
        'registration_open',
        'class_size',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    public function Swimmers()
    {
        return $this->hasMany(Swimmer::class);
    }

    public function Season()
    {
        return $this->belongsTo(Season::class);
    }

    public function Group()
    {
        return $this->belongsTo(Group::class);
    }

    public function Location()
    {
        return $this->belongsTo(Location::class);
    }

    public function DaysOfTheWeek()
    {
        return $this->belongsToMany(DaysOfTheWeek::class)->withTimestamps();
    }
}
