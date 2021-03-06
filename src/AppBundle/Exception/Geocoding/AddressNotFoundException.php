<?php

namespace AppBundle\Exception\Geocoding;

use Exception;

/**
 * AppBundle\Exception\Geocoding\AddressNotFoundException
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class AddressNotFoundException extends Exception implements GeocodingExceptionInterface
{
    /**
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($message = 'No results found', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
