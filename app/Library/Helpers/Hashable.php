<?php


namespace App\Library\Helpers;


trait Hashable
{
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