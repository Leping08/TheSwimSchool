<?php

namespace App;

use App\Library\PoolSessionable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Lesson'
 *
 * @property int $id
 * @property int $season_id
 * @property int $group_id
 * @property int $location_id
 * @property int $price
 * @property int $class_size
 * @property int $instructor_id
 * @property string $days
 * @property \Illuminate\Support\Carbon $registration_open
 * @property \Illuminate\Support\Carbon $class_start_time
 * @property \Illuminate\Support\Carbon $class_end_time
 * @property \Illuminate\Support\Carbon $class_start_date
 * @property \Illuminate\Support\Carbon $class_end_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read Group $group
 * @property-read Location $location
 * @property-read Season $season
 * @property-read Collection $calendarEvents
 * @property-read WaitList $waitlist
 * @property-read User $instructor
 */
class Lesson extends Model implements PoolSessionable
{
    use Actionable, HasFactory, Notifiable, SoftDeletes;

    /**
     * @var array
     */
    protected $casts = [
        'days' => 'array',
        'season_id' => 'integer',
        'group_id' => 'integer',
        'location_id' => 'integer',
        'instructor_id' => 'integer',
        'class_size' => 'integer',
        'registration_open' => 'datetime',
        'class_start_time' => 'datetime',
        'class_end_time' => 'datetime',
        'class_start_date' => 'date',
        'class_end_date' => 'date',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'season_id',
        'group_id',
        'location_id',
        'price',
        'registration_open',
        'class_size',
        'class_start_time',
        'class_end_time',
        'class_start_date',
        'class_end_date',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'days',
    ];

    /**
     * @return HasMany
     */
    public function swimmers(): HasMany
    {
        return $this->hasMany(Swimmer::class);
    }

    /**
     * @return BelongsTo
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    /**
     * @return BelongsToMany
     */
    public function daysOfTheWeek(): BelongsToMany
    {
        return $this->belongsToMany(DaysOfTheWeek::class)->withTimestamps();
    }

    /**
     * @return MorphMany
     */
    public function pool_sessions(): MorphMany
    {
        return $this->morphMany(PoolSession::class, 'pool_sessionable', 'pool_session_type', 'pool_session_id');
    }

    /**
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->class_size <= $this->Swimmers()->count();
    }

    /**
     * @return bool
     */
    public function isPrivate(): bool
    {
        return strpos($this->group->type, 'Private') !== false;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return '/lessons/'.$this->group->type;
    }

    /**
     * @return array
     */
    public function daysOfTheWeekArray(): array
    {
        return collect($this->DaysOfTheWeek()->get())->map(function ($item) {
            return $item->day;
        })->toArray();
    }

    /**
     * @return array
     */
    public function daysOfTheWeekIdsArray(): array
    {
        return collect($this->DaysOfTheWeek()->get())->map(function ($item) {
            return $item->id;
        })->toArray();
    }

    /**
     * @return bool
     */
    public function hasSwimmers(): bool
    {
        return $this->swimmers()->count() > 0;
    }

    /**
     * @return HasMany
     */
    public function waitList()
    {
        return $this->hasMany(WaitList::class)->orderBy('created_at', 'asc');
    }

    /**
     * @param  $query
     * @return mixed
     */
    public function scopeRegistrationOpen($query)
    {
        return $query
            ->whereDate('class_start_date', '>', Carbon::now())
            ->whereDate('registration_open', '<=', Carbon::now());
    }

    /**
     * @param  $query
     * @return mixed
     */
    public function scopeStartingTomorrow($query)
    {
        return $query->where('class_start_date', Carbon::tomorrow());
    }

    /**
     * @param  $query
     * @return mixed
     */
    public function scopeEndedOneWeekAgo($query)
    {
        return $query->whereDate('class_end_date', Carbon::today()->subDays(7));
    }

    /**
     * This is a collection of carbon dates for each pool session
     *
     * @return Collection
     */
    public function getCalendarEventsAttribute()
    {
        $dates = collect();
        foreach ($this->DaysOfTheWeekArray() as $day) {
            $carbonConstants = collect([
                'Monday' => Carbon::MONDAY,
                'Tuesday' => Carbon::TUESDAY,
                'Wednesday' => Carbon::WEDNESDAY,
                'Thursday' => Carbon::THURSDAY,
                'Friday' => Carbon::FRIDAY,
                'Saturday' => Carbon::SATURDAY,
                'Sunday' => Carbon::SUNDAY,
            ]);

            foreach ($carbonConstants as $key => $carbonConstant) {
                if ($key === $day) {
                    $carbonDayConstant = $carbonConstant;
                }
            }

            $startDate = Carbon::parse($this->class_start_date->subDay())->next($carbonDayConstant); // Get the first friday.
            $endDate = Carbon::parse($this->class_end_date);

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                $dates->push($date->toISOString());
            }
        }

        return $dates;
    }

    /**
     * A method to generate pool sessions for a lesson
     *
     * @param  array  $fields
     * @return void
     */
    public function generatePoolSessions(array $unused): void
    {
        // $days = ["1" => true,"2" => true,"3" => true,"4" => false,"5" => false,"6" => false,"7" => false];
        $daysOfTheWeekIds = collect($this->days)->filter(function ($day) {
            return $day === true;
        })->keys();

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
            $startDate = Carbon::parse($this->class_start_date)->subDay()->next($carbonDayMappings->get($dayId));
            $endDate = Carbon::parse($this->class_end_date);

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
                $dates->push(Carbon::parse($date));
            }
        }

        $startTimeString = Carbon::parse($this->class_start_time)->toTimeString();
        $endTimeString = Carbon::parse($this->class_end_time)->toTimeString();

        foreach ($dates as $poolSessionDate) {
            $start = Carbon::parse($poolSessionDate)->setTimeFromTimeString($startTimeString);
            $end = Carbon::parse($poolSessionDate)->setTimeFromTimeString($endTimeString);

            PoolSession::firstOrCreate([
                'start' => $start,
                'end' => $end,
                'location_id' => $this->location_id,
                'instructor_id' => $this->instructor_id,
                'pool_session_id' => $this->id,
                'pool_session_type' => Lesson::class,
            ]);
        }

        $days = collect($this->days)->filter(function ($day) {
            return $day === true;
        })->keys();

        if ($days->count() > 0) {
            Log::info("Setting the days of the week for lesson id {$this->id}.");
            $this->DaysOfTheWeek()->sync($days->toArray());
        }
    }
}
