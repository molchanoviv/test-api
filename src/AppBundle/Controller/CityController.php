<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use AppBundle\Form\Type\CityType;
use AppBundle\Manager\CityManager;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use FOS\RestBundle\View\View;
use Knp\Component\Pager\Pagination\SlidingPagination;
use LogicException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * AppBundle\Controller\CityController
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CityController extends Controller
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     section="City",
     *     description="Get cities list",
     *     statusCodes={
     *         200="Returned when successful",
     *         500= "Something wrong in request"
     *     },
     *     output="array<AppBundle\Entity\City>"
     * )
     * @Rest\Get("/cities.{_format}", name="api.city.list", defaults={"_format"="json"})
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param integer $page
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws LogicException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    public function cgetAction($page = 1)
    {
        /** @var SlidingPagination $entities */
        $entities = $this->getPaginator()->paginate(
            $this->getResourceManager()->getCitiesQuery(),
            $page,
            100
        );

        return $entities->getItems();
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     section="City",
     *     description="Get city by name",
     *     statusCodes={
     *         200="Returned when successful",
     *         500= "Something wrong in request"
     *     },
     *     output="AppBundle\Entity\City"
     * )
     * @Rest\Get("/city.{_format}", name="api.city.get", defaults={"_format"="json"})
     * @Rest\QueryParam(name="name", description="City name")
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param string $name
     *
     * @return City|View
     * @throws LogicException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    public function getAction($name)
    {
        /** @var City $entity */
        $entity = $this->getResourceManager()->findOneBy(['name' => $name]);
        if (false === $this->isEntityValid($entity)) {
            return $this->view(sprintf('Unable to find city with slug %s', $name), 404);
        }

        return $entity;
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     section="City",
     *     description="Create city",
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Not valid data",
     *         500="Something wrong in request"
     *     },
     *     input="AppBundle\Form\Type\CityType",
     *     output="AppBundle\Entity\City"
     * )
     * @Rest\Post("/city.{_format}", name="api.city.post", defaults={"_format"="json"})
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @return array
     * @throws ExceptionInterface
     * @throws UnexpectedValueException
     * @throws BadRequestHttpException
     * @throws LogicException
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    public function postAction()
    {
        return $this->processForm($this->getResourceManager()->createNew());
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     section="City",
     *     description="Edit city",
     *     statusCodes={
     *         200="Returned when successful",
     *         400="Not valid data",
     *         500="Something wrong in request"
     *     },
     *     input="AppBundle\Form\Type\CityType",
     *     output="AppBundle\Entity\City"
     * )
     * @Rest\Put("/city.{_format}", name="api.city.put", defaults={"_format"="json"})
     * @Rest\QueryParam(name="id", requirements="\d+", default="1", description="City identifier")
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param integer $id
     *
     * @return array|View
     * @throws ExceptionInterface
     * @throws UnexpectedValueException
     * @throws BadRequestHttpException
     * @throws LogicException
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    public function putAction($id)
    {
        $entity = $this->getResourceManager()->find($id);
        if (false === $this->isEntityValid($entity)) {
            return $this->view(sprintf('Unable to find city with id %s', $id), 404);
        }

        return $this->processForm($entity, Request::METHOD_PUT);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     section="City",
     *     description="Delete city by id",
     *     statusCodes={
     *         200="Returned when successful",
     *         500= "Something wrong in request"
     *     }
     * )
     * @Rest\Delete("/city.{_format}", name="api.city.delete", defaults={"_format"="json"})
     * @Rest\QueryParam(name="id", requirements="\d+", default="1", description="City identifier")
     * @Rest\View()
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @param integer $id
     *
     * @return array|View
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     * @throws \LogicException
     */
    public function deleteAction($id)
    {
        $entity = $this->getResourceManager()->find($id);
        if (false === $this->isEntityValid($entity)) {
            return $this->view(sprintf('Unable to find city with id %s', $id), 404);
        }
        $this->getResourceManager()->remove($entity);
        $this->getResourceManager()->flush();

        return [];
    }

    /**
     * @return CityManager
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    public function getResourceManager()
    {
        return $this->getCityManager();
    }

    /**
     * @return string
     */
    public function getResourceFormType(): string
    {
        return CityType::class;
    }

    /**
     * @param City|null $entity
     *
     * @return bool
     * @throws LogicException
     */
    private function isEntityValid(City $entity = null)
    {
        return null !== $entity;
    }
}
