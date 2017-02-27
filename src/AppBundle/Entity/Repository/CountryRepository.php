<?php
declare(strict_types = 1);

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * AppBundle\Entity\Repository\CountryRepository
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CountryRepository extends EntityRepository
{
    /**
     * @param string $term
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function findByNamePart($term)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.name LIKE :term')
            ->setParameter('term', "%{$term}%")
            ->orderBy('c.name');

        return $qb->getQuery()->getResult();
    }
}
