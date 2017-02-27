<?php

namespace AppBundle\Exception\Geocoding;

use Exception;

/**
 * AppBundle\Exception\Geocoding\QueryLimitException
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class QueryLimitException extends Exception implements GeocodingExceptionInterface
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = 'You are reached query limit', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
