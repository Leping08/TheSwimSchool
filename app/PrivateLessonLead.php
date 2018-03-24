<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateLessonLead extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'length',
        'location',
        'availability'
    ];
}
