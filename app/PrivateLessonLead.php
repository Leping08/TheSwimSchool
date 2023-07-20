<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class PrivateLessonLead extends Model
{
    use SoftDeletes, Actionable;

    /**
     * @var array
     */
    protected $casts = [
        'swimmer_birth_date' => 'datetime'
    ];

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
        'hr_resident',
        'availability',
        'address',
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
