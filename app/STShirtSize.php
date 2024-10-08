<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class STShirtSize extends Model
{
    use Actionable, HasFactory, SoftDeletes;

    protected $table = 's_t_shirt_sizes';

    public function swimmers()
    {
        return $this->hasMany(STSwimmer::class, 's_t_shirt_size_id');
    }
}
