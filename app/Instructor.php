<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'phone', 'email', 'image', 'bio', 'configuration'];

    /**
     * @var array
     */
    protected $casts = [
        'configuration' => 'array',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
