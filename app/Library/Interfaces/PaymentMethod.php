<?php

namespace App\Library\Interfaces;

interface PaymentMethod
{
    public function charge();
}