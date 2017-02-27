<?php
declare(strict_types = 1);

namespace AppBundle\Service;

use AppBundle\DTO\CoordinatesDto;
use AppBundle\Exception\Geocoding\InvalidRequestException;
use AppBundle\Exception\Geocoding\AddressNotFoundException;
use AppBundle\Exception\Geocoding\QueryLimitException;
use AppBundle\Exception\Geocoding\RequestDeniedException;
use AppBundle\Exception\Geocoding\UnknownErrorException;
use GuzzleHttp\Client;

/**
 * AppBundle\Service\GoogleGeocoding
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class GoogleGeocoding
{
    const STATUS_OK = 'OK';
    const STATUS_ZERO_RESULTS = 'ZERO_RESULTS';
    const STATUS_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const STATUS_REQUEST_DENIED = 'REQUEST_DENIED';
    const STATUS_INVALID_REQUEST = 'INVALID_REQUEST';
    const STATUS_UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * GoogleGeocoding constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $address
     *
     * @return CoordinatesDto
     * @throws AddressNotFoundException
     * @throws UnknownErrorException
     * @throws RequestDeniedException
     * @throws QueryLimitException
     * @throws InvalidRequestException
     * @throws \RuntimeException
     */
    public function getAddressCoordinates(string $address): CoordinatesDto
    {
        $client = new Client();
        $url = sprintf(
            'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s',
            $address,
            $this->apiKey
        );
        $res = $client->request('GET', $url);
        $response = json_decode($res->getBody()->getContents(), true);
        if ($response['status'] === self::STATUS_OVER_QUERY_LIMIT) {
            throw new QueryLimitException();
        }
        if ($response['status'] === self::STATUS_REQUEST_DENIED) {
            throw new RequestDeniedException();
        }
        if ($response['status'] === self::STATUS_INVALID_REQUEST) {
            throw new InvalidRequestException();
        }
        if ($response['status'] === self::STATUS_UNKNOWN_ERROR) {
            throw new UnknownErrorException();
        }
        if ($response['status'] === self::STATUS_ZERO_RESULTS) {
            throw new AddressNotFoundException();
        }
        ['lat' => $latitude, 'lng' => $longitude] = current($response['results'])['geometry']['location'];

        return new CoordinatesDto($latitude, $longitude);
    }
}
