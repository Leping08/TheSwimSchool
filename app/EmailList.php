<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * This is a marketing email list
 *
 * An Eloquent Model: 'EmailList'
 *
 * @property integer $id
 * @property string $email
 * @property bool $subscribe
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 *
 */

class EmailList extends Model
{
    use Actionable, HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['email', 'subscribe'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeSubscribed($query)
    {
        return $query->where('subscribe', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('subscribe', false);
    }

    /**
     * @return bool
     */
    public function unsubscribe() : bool
    {
        return $this->update([
            'subscribe' => 0
        ]);
    }

    /**
     * @return bool
     */
    public function resubscribe() : bool
    {
        return $this->update([
            'subscribe' => 1
        ]);
    }

    /**
     * @return string
     */
    public function getRouteKeyName() {
        return 'email';
    }
}
