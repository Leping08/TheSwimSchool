<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['group_id', 'description'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
