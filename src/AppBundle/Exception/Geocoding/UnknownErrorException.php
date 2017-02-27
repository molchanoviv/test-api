<?php

namespace AppBundle\Exception\Geocoding;

use Exception;

/**
 * AppBundle\Exception\Geocoding\UnknownErrorException
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class UnknownErrorException extends Exception implements GeocodingExceptionInterface
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = 'Unknown error', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
