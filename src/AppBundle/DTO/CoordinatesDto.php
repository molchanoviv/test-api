<?php
declare(strict_types = 1);

namespace AppBundle\DTO;

/**
 * AppBundle\DTO\CoordinatesDto
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CoordinatesDto
{
    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * CoordinatesDto constructor.
     *
     * @param float $latitude
     * @param       $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return CoordinatesDto
     */
    public function setLatitude(float $latitude): CoordinatesDto
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return CoordinatesDto
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }
}
