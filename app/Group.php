<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Group extends Model
{
    protected $fillable = ['type', 'ages', 'description'];

    public function Lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function OpenSignUps()
    {
        return $this->hasMany(Lesson::class)
                    ->where([
                        ['registration_open', '<=', Carbon::now()],
                        ['class_end_date', '>=', Carbon::now()]
                    ]);
    }
}
