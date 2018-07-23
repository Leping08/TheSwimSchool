<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailList extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['email', 'subscribe'];
}
