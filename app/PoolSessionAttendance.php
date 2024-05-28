<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class PoolSessionAttendance extends Pivot
{
    use SoftDeletes, HasFactory, Actionable;

    protected $table = 'pool_session_attendance';

    protected $fillable = [
        'pool_session_id',
        'attended',
        'swimmable_id',
        'swimmable_type',
    ];

    protected $casts = [
        'attended' => 'boolean',
    ];

    public function pool_session()
    {
        return $this->belongsTo(PoolSession::class);
    }

    public function swimmable()
    {
        return $this->morphTo('swimmer', 'swimmable_type', 'swimmable_id');
    }

    public function scopeAttended($query)
    {
        return $query->where('attended', true);
    }

    public function scopeNotAttended($query)
    {
        return $query->where('attended', false);
    }
}
