<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Swimmer extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
