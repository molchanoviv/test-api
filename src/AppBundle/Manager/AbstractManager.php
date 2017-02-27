<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\TransactionRequiredException;

/**
 * AppBundle\Manager\AbstractManager.
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
abstract class AbstractManager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @return string
     */
    abstract public function getEntityClassName();

    /**
     * Return repository of entity handled by the manager.
     *
     * @return EntityRepository
     */
    abstract public function getEntityRepository();

    /**
     * @param ObjectManager $entityManager
     *
     * @return AbstractManager
     */
    public function setEntityManager(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return object
     *
     * @throws ORMInvalidArgumentException
     */
    public function createNew()
    {
        $entityClassName = $this->getEntityClassName();

        return new $entityClassName();
    }

    /**
     * @param object $entity
     *
     * @return object|void
     *
     * @throws ORMInvalidArgumentException
     */
    public function refresh($entity)
    {
        $this->entityManager->refresh($entity);
    }

    /**
     * @param object $entity
     *
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
    }

    /**
     * @param object $entity
     *
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    /**
     * @param object $entity
     *
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     */
    public function merge($entity)
    {
        $this->entityManager->merge($entity);
    }

    /**
     * @param object|null $entity
     *
     * @throws OptimisticLockException
     */
    public function flush($entity = null)
    {
        $this->entityManager->flush($entity);
    }

    /**
     * @param object $entity
     *
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     */
    public function save($entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    /**
     * @param null $entity
     */
    public function clear($entity = null)
    {
        $this->entityManager->clear($entity);
    }

    /**
     * @param int      $id
     * @param int      $lockMode
     * @param int|null $lockVersion
     *
     * @return null|object
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws TransactionRequiredException
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->getEntityRepository()->find($id, $lockMode, $lockVersion);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getEntityRepository()->findAll();
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     * @throws \RuntimeException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getEntityRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     * @throws \RuntimeException
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getEntityRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }
}
