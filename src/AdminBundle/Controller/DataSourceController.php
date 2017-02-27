<?php
declare(strict_types = 1);

namespace AdminBundle\Controller;

use AppBundle\Controller\ManagersControllerTrait;
use AppBundle\Entity\City;
use AppBundle\Entity\Country;
use AppBundle\Entity\Region;
use Doctrine\Common\Cache\Cache;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

/**
 * AdminBundle\Controller\DataSourceController
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class DataSourceController extends Controller
{
    use ManagersControllerTrait;

    /**
     * @Route("/find-regions", name="find-regions", options={"expose" = true})
     *
     * @param Request $request
     *
     * @return Response
     * @throws InvalidArgumentException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws UnexpectedValueException
     * @throws \Exception
     */
    public function findCitiesAction(Request $request)
    {
        $term = $request->get('q');
        $cache = $this->getCache();
        $cacheKey = 'regions-'.$term;
        if ($cache->contains($cacheKey)) {
            return $this->returnJson($cache->fetch($cacheKey));
        }
        $regions = [];
        /** @var Region $region */
        foreach ($this->getRegionManager()->findByNamePart($term) as $region) {
            $regions[] = [
                'id' => $region->getId(),
                'text' => sprintf('%s (%s)', $region->getName(), $region->getCountry()->getName()),
            ];
        }
        $cache->save($cacheKey, $regions);

        return $this->returnJson($regions);
    }

    /**
     * Return a properly formatted JSON Response
     *
     * @param  array|mixed $data
     * @param  Response    $response
     * @param  integer     $statusCode
     * @param  array       $headers
     *
     * @throws UnexpectedValueException
     * @throws InvalidArgumentException
     * @return Response
     */
    protected function returnJson(
        $data,
        Response $response = null,
        $statusCode = 200,
        array $headers = []
    ) {
        if (null === $response) {
            $response = new Response();
        }
        if (!isset($headers['Content-type'])) {
            $headers['Content-type'] = 'application/json';
        }

        @$response->setContent(json_encode($data));
        $response->setStatusCode($statusCode);
        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        return $response;
    }

    /**
     * @return Cache
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    protected function getCache()
    {
        return $this->get('doctrine_cache.providers.app');
    }
}
