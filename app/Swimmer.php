<?php

namespace App;

use App\Library\Helpers\Ages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Swimmer'
 *
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon $birthDate
 * @property boolean $paid
 * @property string $stripeChargeId
 * @property string $parent
 * @property string $notes
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $emergencyName
 * @property string $emergencyRelationship
 * @property string $emergencyPhone
 * @property integer $lesson_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Lesson $lesson
 */

class Swimmer extends Model
{
    use SoftDeletes, Ages, Actionable;

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
}
