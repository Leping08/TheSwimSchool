<?php

namespace App\Library\Helpers;

use App\Athlete;

class RandomString
{
    public static function generate($length = 12)
    {  //1,034,716,802,229,536,025,600 unique combinations using 12 characters
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $size = strlen($chars);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }

    public static function setAthleteHash()
    {
        foreach (Athlete::all() as $athlete) {
            $athlete->hash = self::generate();
            $athlete->save();
        }
    }
}
