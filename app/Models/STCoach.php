<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Season'.
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property bool $active
 * @property string $bio
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class STCoach extends Model
{
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
