<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    protected $fillable = ['name', 'phone', 'message', 'email', 'contact_type_id'];

    public function Type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }
}