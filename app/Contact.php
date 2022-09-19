<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

/**
 * The people who have contacted site admins
 *
 * An Eloquent Model: 'Contact'
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property bool $followed_up
 * @property bool $contact_type_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 * @property-read \App\ContactType $type
 */
class Contact extends Model
{
    use SoftDeletes, Actionable;

    /**
     * @var array
     */
    protected $fillable = ['name', 'phone', 'message', 'email', 'contact_type_id'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }
}
