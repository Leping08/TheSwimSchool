<?php

namespace App;

use App\Library\PoolSessionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'PrivateLesson'
 *
 * @property int $id
 * @property string $season_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Season $season
 * @property-read PoolSession $pool_sessions
 * @property-read PrivateSwimmer $swimmer
 */
class PrivateLesson extends Model implements PoolSessionable
{
    use Actionable, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['season_id'];

    /**
     * @return BelongsTo
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * @return MorphMany
     */
    public function pool_sessions(): MorphMany
    {
        return $this->morphMany(PoolSession::class, 'pool_sessionable', 'pool_session_type', 'pool_session_id');
    }

    /**
     * @return HasOne
     */
    public function swimmer(): HasOne
    {
        return $this->hasOne(PrivateSwimmer::class, 'private_lesson_id');
    }

    /**
     * @return string
     */
    public function swimmers()
    {
        return $this->hasMany(PrivateSwimmer::class, 'private_lesson_id');
    }

    /**
     * @param  array  $fields
     * @return void
     */
    public function generatePoolSessions(array $fields): void
    {
        // $days = ["1" => true,"2" => true,"3" => true,"4" => false,"5" => false,"6" => false,"7" => false];
        $daysOfTheWeekIds = collect(data_get($fields, 'days'))->filter(function ($value, $key) {
            return $value === true;
        })->keys()->toArray();
        $dates = collect();

        foreach ($daysOfTheWeekIds as $dayId) {
            $carbonDayMappings = collect([
                1 => Carbon::MONDAY,
                2 => Carbon::TUESDAY,
                3 => Carbon::WEDNESDAY,
                4 => Carbon::THURSDAY,
                5 => Carbon::FRIDAY,
                6 => Carbon::SATURDAY,
                7 => Carbon::SUNDAY,
            ]);

            // Parse the date and go back one day to account for the start date being accessible
            $startDate = Carbon::parse(data_get($fields, 'start_date_time'))->subDay()->next($carbonDayMappings->get($dayId));
            $endDate = Carbon::parse(data_get($fields, 'end_date_time'));

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                $dates->push(Carbon::parse($date));
            }
        }

        $startTimeString = Carbon::parse(data_get($fields, 'start_date_time'))->toTimeString();
        $endTimeString = Carbon::parse(data_get($fields, 'end_date_time'))->toTimeString();

        foreach ($dates as $poolSessionDate) {
            $start = Carbon::parse($poolSessionDate)->setTimeFromTimeString($startTimeString);
            $end = Carbon::parse($poolSessionDate)->setTimeFromTimeString($endTimeString);

            // Find or create a pool session
            PoolSession::firstOrCreate([
                'start' => $start,
                'end' => $end,
                'location_id' => data_get($fields, 'location_id'),
                'instructor_id' => data_get($fields, 'instructor_id'),
                'price' => data_get($fields, 'price'),
                'pool_session_id' => null,
                'pool_session_type' => PrivateLesson::class,
            ]);
        }
    }
}
