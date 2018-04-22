<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class STSwimmer extends Model
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

    public function level()
    {
        return $this->belongsTo(STLevel::class, 's_t_level_id');
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
