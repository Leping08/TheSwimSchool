<?php

namespace App;

use App\Library\Helpers\Ages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class PrivateSwimmer extends Model
{
    use Actionable, Ages, HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

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
    ];

    /**
     * @return BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(PrivateLesson::class, 'private_lesson_id');
    }

    public function attendances()
    {
        return $this->morphMany(PoolSessionAttendance::class, 'swimmable', 'swimmable_type', 'swimmable_id');
    }
}
