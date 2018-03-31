<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Swimmer extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'birthDate'];

    /**
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate',
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
        'stripeChargeId'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * @return mixed
     */
    public function yearsOld()
    {
        return $this->getAttribute('birthDate')->diffInYears(Carbon::now());
    }

    /**
     * @return mixed
     */
    public function monthsOld()
    {
        return $this->getAttribute('birthDate')->diffInMonths(Carbon::now());
    }
}
