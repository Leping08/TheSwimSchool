<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageParameters extends Model
{
    use HasFactory, SoftDeletes;

    const NEWS_LETTER_EMAIL = 'News Letter Email';

    protected $fillable = [
        'name',
        'configuration',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'configuration' => 'array',
    ];

    public static function getNewsLetterEmail()
    {
        return self::where('name', self::NEWS_LETTER_EMAIL)->first();
    }
}
