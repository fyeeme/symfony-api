<?php

namespace App\Exception;


use Throwable;

class AccessDeniedException extends \Exception
{
    public function __construct(string $message = "access denied", int $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}