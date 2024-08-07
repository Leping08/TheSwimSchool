<?php

namespace App;

use App\Library\Helpers\Ages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Swimmer'
 *
 * @property int $id
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon $birthDate
 * @property bool $paid
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
 * @property int $lesson_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\Lesson $lesson
 * @property-read $encryptedId
 */
class Swimmer extends Model
{
    use Actionable, Ages, HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $casts = [
        'birthDate' => 'date',
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
        'stripeChargeId',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function attendances()
    {
        return $this->morphMany(PoolSessionAttendance::class, 'swimmable', 'swimmable_type', 'swimmable_id');
    }

    public static function findByEncryptedId(string $encrypted_swimmer_id)
    {
        return Swimmer::find(Crypt::decryptString($encrypted_swimmer_id));
    }

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }

    public function getEncryptedIdAttribute()
    {
        return Crypt::encryptString((string) $this->id);
    }

    public function graduated(): bool
    {
        // Check if no progress reports exist
        if ($this->progressReports->isEmpty()) {
            return false;
        }

        // Check if all progress reports have passed
        return $this->progressReports->every(function ($report) {
            return $report->passed;
        });
    }
}
