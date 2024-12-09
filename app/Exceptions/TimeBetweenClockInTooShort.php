<?php

namespace App\Exceptions;

use Exception;

class TimeBetweenClockInTooShort extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exception.time_between_clock_in_too_short'));
    }
}
