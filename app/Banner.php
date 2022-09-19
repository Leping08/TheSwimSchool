<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

/**
 * A banner is used on the top of the page
 *
 * An Eloquent Model: 'Banner'
 *
 * @property int $id
 * @property bool $active
 * @property string $page
 * @property string $text
 */
class Banner extends Model
{
    use Actionable, HasFactory;

    protected $fillable = [
        'active',
        'page',
        'text',
    ];
}
