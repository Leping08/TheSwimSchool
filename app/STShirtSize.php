<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class STShirtSize extends Model
{
    use SoftDeletes;

    protected $table = 's_t_shirt_sizes';

    public function swimmers()
    {
        return $this->hasMany(STSwimmer::class, 's_t_shirt_size_id');
    }
}
