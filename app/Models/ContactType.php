<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * All the different ways people contact admins on the site
 *
 * An Eloquent Model: 'ContactType'
 *
 * @property integer $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */

class ContactType extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
