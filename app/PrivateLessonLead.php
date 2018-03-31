<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PrivateLessonLead extends Model
{
    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'swimmer_birth_date'];

    /**
     * @var array
     */
    protected $fillable = [
        'swimmer_name',
        'swimmer_birth_date',
        'email',
        'phone',
        'type',
        'length',
        'location',
        'availability'
    ];

    /**
     * @return mixed
     */
    public function yearsOld()
    {
        return $this->getAttribute('swimmer_birth_date')->diffInYears(Carbon::now());
    }

    /**
     * @return mixed
     */
    public function monthsOld()
    {
        return $this->getAttribute('swimmer_birth_date')->diffInMonths(Carbon::now());
    }
}
