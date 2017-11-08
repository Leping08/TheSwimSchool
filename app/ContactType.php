<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    public function Contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
