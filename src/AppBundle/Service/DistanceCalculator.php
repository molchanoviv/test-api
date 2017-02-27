<?php

namespace AppBundle\Service;

use AppBundle\DTO\CoordinatesDto;

/**
 * AppBundle\Helper\DistanceCalculator
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class DistanceCalculator
{
    private const EARTH_RADIUS = 6378137;

    /**
     * Calculate distance between points by Haversine formula
     *
     * @param CoordinatesDto $point1
     * @param CoordinatesDto $point2
     *
     * @return float
     */
    public function calculate(CoordinatesDto $point1, CoordinatesDto $point2): float
    {
        $latitudeDistance = deg2rad($point2->getLatitude() - $point1->getLatitude());
        $longitudeDistance = deg2rad($point2->getLongitude() - $point1->getLongitude());
        $a = sin($latitudeDistance / 2) * sin($latitudeDistance / 2) +
            cos(deg2rad($point1->getLatitude())) * cos(deg2rad($point2->getLatitude())) *
            sin($longitudeDistance / 2) * sin($longitudeDistance / 2);

        return 2 * atan2(sqrt($a), sqrt(1 - $a)) * self::EARTH_RADIUS;
    }
}
