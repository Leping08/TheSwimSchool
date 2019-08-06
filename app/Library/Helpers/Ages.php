<?php

namespace App\Library\Helpers;

use Carbon\Carbon;

trait Ages
{
    /**
     * @return int
     */
    public function yearsOld()
    {
        return Carbon::parse($this->getDate())->diffInYears(Carbon::now());
    }

    /**
     * @return int
     */
    public function monthsOld()
    {
        return Carbon::parse($this->getDate())->diffInMonths(Carbon::now());
    }

    /**
     * @return string|null
     */
    private function getDate()
    {
        if ($this->getAttribute('date_of_birth')) {
            return $this->getAttribute('date_of_birth');
        } elseif ($this->getAttribute('birthDate')) {
            return $this->getAttribute('birthDate');
        } else {
            return;
        }
    }
}
