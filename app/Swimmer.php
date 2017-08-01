<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Swimmer extends Model
{
    protected $fillable = [
        'name',
        'age',
        'email',
        'phone',
        'paid',
        'lesson_id',
        'parent',
        'notes',
        'street',
        'city',
        'state',
        'zip',
        'emergencyName',
        'emergencyRelationship',
        'emergencyPhone',
        'stripechargeid'
    ];

    public function Lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
