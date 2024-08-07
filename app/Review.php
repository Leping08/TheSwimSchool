<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;

/**
 * An Eloquent Model: 'Location'
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property string $created_time
 * @property string $message
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class Review extends Model
{
    use Actionable, HasFactory, SoftDeletes;

    protected $fillable = ['name', 'active', 'created_time', 'message'];

    protected $appends = ['short_message'];

    public function getShortMessageAttribute()
    {
        return Str::limit($this->message, 300);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
