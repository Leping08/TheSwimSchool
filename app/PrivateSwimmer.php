<?php

namespace App;

use App\Library\Helpers\Ages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class PrivateSwimmer extends Model
{
    use SoftDeletes, Ages, Actionable;

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'birth_date'];

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'parent',
        'notes',
        'street',
        'city',
        'state',
        'zip',
        'emergency_name',
        'emergency_relationship',
        'emergency_phone',
        'stripe_charge_id',
        'private_lesson_id',
        'private_lesson_id',
        'private_lesson_id'
    ];

    public function lesson()
    {
        return $this->belongsTo(PrivateLesson::class, 'private_lesson_id');
    }
}
