<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
