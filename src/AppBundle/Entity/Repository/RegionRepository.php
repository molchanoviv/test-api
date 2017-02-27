<?php
declare(strict_types = 1);

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AppBundle\Entity\Repository\RegionRepository
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class RegionRepository extends EntityRepository
{
    /**
     * @param string $term
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function findByNamePart($term)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.name LIKE :term')
            ->setParameter('term', "%{$term}%")
            ->orderBy('r.name');

        return $qb->getQuery()->getResult();
    }
}
