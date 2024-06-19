<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgressReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'passed' => 'boolean',
    ];

    protected $fillable = [
        'swimmer_id',
        'skill_id',
        'passed',
    ];

    public function swimmer()
    {
        return $this->belongsTo(Swimmer::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
