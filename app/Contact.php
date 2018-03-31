<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

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
