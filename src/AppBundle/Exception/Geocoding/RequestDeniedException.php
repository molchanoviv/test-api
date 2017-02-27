<?php

namespace AppBundle\Exception\Geocoding;

use Exception;

/**
 * AppBundle\Exception\Geocoding\RequestDeniedException
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class RequestDeniedException extends Exception implements GeocodingExceptionInterface
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = 'Access denied', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
