<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Swimmer extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at', 'birthDate'];

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

    public function Lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function yearsOld() {
        return $this->birthDate->diffInYears(Carbon::now());
    }

    public function monthsOld() {
        return $this->birthDate->diffInMonths(Carbon::now());
    }
}
