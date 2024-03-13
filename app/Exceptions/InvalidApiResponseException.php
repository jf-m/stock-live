<?php

namespace App\Exceptions;

use Exception;

class InvalidApiResponseException extends Exception
{
    /**
     * @var int
     */
    protected $code = 503; // 503 Service Unavailable
}
