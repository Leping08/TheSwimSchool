<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['name', 'created_time', 'message', 'reviewer_id'];

    protected $appends = ['short_message'];

    public function getShortMessageAttribute()
    {
        return str_limit($this->message, 300);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
