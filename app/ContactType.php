<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * All the different ways people contact admins on the site
 *
 * An Eloquent Model: 'ContactType'
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ContactType extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
