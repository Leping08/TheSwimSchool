<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Swimmer;

class Lesson extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
        'registration_open'
    ];

    public function Swimmers()
    {
        return $this->hasMany(Swimmer::class);
    }
}
