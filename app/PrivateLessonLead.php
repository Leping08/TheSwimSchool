<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateLessonLead extends Model
{
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
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
