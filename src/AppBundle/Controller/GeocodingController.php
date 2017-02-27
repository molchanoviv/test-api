<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\DTO\CoordinatesDto;
use AppBundle\Exception\Geocoding\InvalidRequestException;
use AppBundle\Exception\Geocoding\AddressNotFoundException;
use AppBundle\Exception\Geocoding\QueryLimitException;
use AppBundle\Exception\Geocoding\RequestDeniedException;
use AppBundle\Exception\Geocoding\UnknownErrorException;
use AppBundle\Service\DistanceCalculator;
use AppBundle\Service\GoogleGeocoding;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * AppBundle\Controller\GeocodingController
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class GeocodingController extends Controller
{
    use ManagersControllerTrait;

    /**
     * @ApiDoc(
     *     resource=true,
     *     section="Geocoding",
     *     description="Check if address is close to passed coordinates",
     *     statusCodes={
     *         200="Returned when successful",
     *         500= "Something wrong in request"
     *     },
     * )
     * @Rest\Get("/geocoding.{_format}", name="api.geocoding.check_address", defaults={"_format"="json"})
     * @Rest\QueryParam(name="address", description="Address")
     * @Rest\QueryParam(name="latitude", description="GPS latitude of searching area center")
     * @Rest\QueryParam(name="longitude", description="GPS longitude of searching area center")
     * @Rest\QueryParam(name="distance", default="1000", description="Distance of searching area from center in meters")
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param string $address
     * @param string $latitude
     * @param string $longitude
     * @param string $distance
     *
     * @return Response
     * @throws AddressNotFoundException
     * @throws \RuntimeException
     * @throws UnknownErrorException
     * @throws RequestDeniedException
     * @throws QueryLimitException
     * @throws InvalidRequestException
     * @throws \InvalidArgumentException
     */
    public function geocodingAction($address, $latitude, $longitude, $distance)
    {
        if (empty($address)) {
            throw new \InvalidArgumentException('Parameter address is missing');
        }
        if (empty($latitude)) {
            throw new \InvalidArgumentException('Parameter latitude is missing');
        }
        if (empty($longitude)) {
            throw new \InvalidArgumentException('Parameter longitude is missing');
        }

        $geocoding = $this->getGeocoding();
        $point1 = $geocoding->getAddressCoordinates($address);
        $distanceBetweenPoints = $this->getDistanceCalculator()->calculate(
            $point1,
            new CoordinatesDto((float) $latitude, (float) $longitude)
        );

        return new JsonResponse(['fits' => $distanceBetweenPoints <= (float) $distance]);
    }

    /**
     * @return GoogleGeocoding
     */
    protected function getGeocoding()
    {
        return $this->get('app.service.google_geocoding');
    }

    /**
     * @return DistanceCalculator
     */
    protected function getDistanceCalculator()
    {
        return $this->get('app.service.distance_calculator');
    }
}
