<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\Country;
use AppBundle\Entity\Repository\CountryRepository;
use Doctrine\ORM\Query;

/**
 * AppBundle\Manager\CountryManager
 *
 * @method Country createNew()
 * @method void refresh(Country $entity)
 * @method void remove(Country $entity)
 * @method void persist(Country $entity)
 * @method void merge(Country $entity)
 * @method void flush(Country $entity = null)
 * @method void save(Country $entity)
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country[] findAll()
 * @method Country[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CountryManager extends AbstractManager
{
    /**
     * @var CountryRepository
     */
    protected $repository;

    /**
     * CountryManager constructor.
     *
     * @param CountryRepository $repository
     */
    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getEntityClassName()
    {
        return Country::class;
    }

    /**
     * Return repository of entity handled by the manager.
     *
     * @return CountryRepository
     */
    public function getEntityRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $name
     * @param string $code
     *
     * @return Country
     */
    public function createCountry(string $name, string $code): Country
    {
        $country = $this->createNew();
        $country->setName($name);
        $country->setCode($code);

        return $country;
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
