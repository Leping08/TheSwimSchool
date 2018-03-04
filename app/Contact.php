<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'phone', 'message', 'email', 'contact_type_id'];

    protected $dates = ['deleted_at'];

    public function Type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }
}
