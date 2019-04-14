<?php

namespace App\Exception;

/**
 * General Exception
 *
 */
class Exception extends \Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code, null);
    }
}