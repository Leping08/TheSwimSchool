<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $dates = [
        'registration_open',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
        'deleted_at'
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

    public function isLessonFull(): bool
    {
        if($this->class_size <= $this->Swimmers()->count()){
            return true;
        } else {
            return false;
        }
    }
//
//    public function isPrivate()
//    {
//        return $this->Group()->type;
//        if(strpos($group->type, 'Private') !== false){
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function path(): string
    {
        return '/lessons/'.$this->Group->type;
    }

    public function DaysOfTheWeekArray(): array
    {
        return collect($this->DaysOfTheWeek())->map(function ($item) {
            return $item->day;
        })->toArray();
    }

    public function DaysOfTheWeekIdsArray(): array
    {
        return collect($this->DaysOfTheWeek())->map(function ($item) {
            return $item->id;
        })->toArray();
    }

    public function hasSwimmers(): bool
    {
        if($this->Swimmers()->count() > 0){
            return true;
        }
        return false;
    }
}
