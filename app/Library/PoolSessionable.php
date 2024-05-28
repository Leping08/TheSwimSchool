<?php

namespace App\Library;

interface PoolSessionable
{
    public function generatePoolSessions(array $fields);

    public function pool_sessions();
}
