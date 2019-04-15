<?php


namespace App\Library\Helpers;


trait Hashable
{
    /**
     *  This creates the has on the model creating hook
     */
    public static function boot()
    {
        static::creating(function ($model) {
            $model->hash = RandomString::generate();
        });
    }

    /**
     * @param $query
     * @param $hash
     * @return mixed
     */
    public function scopeHash($query, $hash)
    {
        return $query->where('hash', '=', $hash);
    }
}