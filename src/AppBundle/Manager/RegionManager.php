<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\Country;
use AppBundle\Entity\Region;
use AppBundle\Entity\Repository\RegionRepository;

/**
 * AppBundle\Manager\RegionManager
 *
 * @method Region createNew()
 * @method void refresh(Region $entity)
 * @method void remove(Region $entity)
 * @method void persist(Region $entity)
 * @method void merge(Region $entity)
 * @method void flush(Region $entity = null)
 * @method void save(Region $entity)
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region[] findAll()
 * @method Region[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class RegionManager extends AbstractManager
{
    /**
     * @var RegionRepository
     */
    protected $repository;

    /**
     * RegionManager constructor.
     *
     * @param RegionRepository $repository
     */
    public function __construct(RegionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getEntityClassName()
    {
        return Region::class;
    }

    /**
     * Return repository of entity handled by the manager.
     *
     * @return RegionRepository
     */
    public function getEntityRepository()
    {
        return $this->repository;
    }

    /**
     * @param string  $name
     * @param Country $country
     *
     * @return Region
     */
    public function createRegion(string $name, Country $country): Region
    {
        $region = $this->createNew();
        $region->setName($name);
        $region->setCountry($country);

        return $region;
    }

    /**
     * @param string $term
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function findByNamePart($term)
    {
        return $this->getEntityRepository()->findByNamePart($term);
    }
}
