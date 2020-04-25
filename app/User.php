<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Nova\Actions\Actionable;

/**
 * An user is currently an admin for the system
 *
 * An Eloquent Model: 'User'
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at //TODO add deleted at to admins
 * @property-read PrivatePoolSession $pool_sessions
 *
 */

class User extends Authenticatable
{
    use Notifiable, Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pool_sessions()
    {
        return $this->hasMany(PrivatePoolSession::class, 'user_id');
    }
}
