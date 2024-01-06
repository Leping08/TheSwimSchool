<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * An Eloquent Model: 'Attendance'
 * 
 * @property int $id
 * @property int $pool_session_id
 * @property int $swimmer_id
 * @property string $swimmer_type
 * @property bool $attended
 * @property string $notes
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'pool_session_id',
        'swimmer_id',
        'swimmer_type',
        'attended',
        'notes'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pool_session()
    {
        return $this->belongsTo(PoolSession::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function swimmer()
    {
        return $this->morphTo();
    }
}
