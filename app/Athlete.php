<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * An athlete is someone who has signed up for a tryout
 */

class Athlete extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'birthDate'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate',
        'email',
        'phone',
        'tryout_id',
        'parent',
        'notes',
        'street',
        'city',
        'state',
        'zip',
        'emergencyName',
        'emergencyRelationship',
        'emergencyPhone'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Tryout()
    {
        return $this->belongsTo(Tryout::class);
    }
}
