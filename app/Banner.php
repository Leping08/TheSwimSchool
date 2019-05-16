<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * A banner is used on the top of the page
 *
 * An Eloquent Model: 'Banner'
 *
 * @property integer $id
 * @property bool $active
 * @property string $page
 * @property string $text
 */

class Banner extends Model
{
    protected $fillable = [
        'active',
        'page',
        'text'
    ];
}
