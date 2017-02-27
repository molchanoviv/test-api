<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\City;
use AppBundle\Entity\Region;
use AppBundle\Entity\Repository\CityRepository;
use Doctrine\ORM\Query;

/**
 * AppBundle\Manager\CityManager
 *
 * @method City createNew()
 * @method void refresh(City $entity)
 * @method void remove(City $entity)
 * @method void persist(City $entity)
 * @method void merge(City $entity)
 * @method void flush(City $entity = null)
 * @method void save(City $entity)
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City[] findAll()
 * @method City[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CityManager extends AbstractManager
{
    /**
     * @var CityRepository
     */
    protected $repository;

    /**
     * CityManager constructor.
     *
     * @param CityRepository $repository
     */
    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getEntityClassName()
    {
        return City::class;
    }

    /**
     * Return repository of entity handled by the manager.
     *
     * @return CityRepository
     */
    public function getEntityRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $name
     * @param Region $region
     *
     * @return City
     */
    public function createCity(string $name, Region $region = null): City
    {
        $city = $this->createNew();
        $city->setName($name);
        if (null !== $region) {
            $city->setRegion($region);
        }

        return $city;
    }

    /**
     * @return Query
     * @throws \InvalidArgumentException
     */
    public function getCitiesQuery(): Query
    {
        return $this->repository->getCitiesQuery();
    }
}
