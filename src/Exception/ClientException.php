<?php

namespace App\Exception;

/**
 * Client Exception
 *
 */
class ClientException extends \Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct($message, $code)
    {
        parent::__construct($message, $code, null);
    }
}