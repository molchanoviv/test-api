<?php
declare(strict_types = 1);

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * AppBundle\Entity\Repository\CityRepository
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CityRepository extends EntityRepository
{
    /**
     * @return Query
     * @throws \InvalidArgumentException
     */
    public function getCitiesQuery()
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->orderBy('c.id');

        return $qb->getQuery();
    }
}
