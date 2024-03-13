<?php

namespace App\Exceptions;

use Exception;

/**
 * The response from the Third Party API was invalid, unexpected, incomplete or malformed
 */
class InvalidApiResponseException extends Exception
{
    /**
     * @var int
     */
    protected $code = 503; // 503 Service Unavailable
}
