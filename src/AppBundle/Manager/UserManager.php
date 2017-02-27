<?php
declare(strict_types = 1);

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Entity\Repository\UserRepository;

/**
 * AppBundle\Manager\UserManager
 *
 * @method User createNew()
 * @method void refresh(User $entity)
 * @method void remove(User $entity)
 * @method void persist(User $entity)
 * @method void merge(User $entity)
 * @method void flush(User $entity = null)
 * @method void save(User $entity)
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class UserManager extends AbstractManager
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserManager constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return string
     */
    public function getEntityClassName()
    {
        return User::class;
    }

    /**
     * Return repository of entity handled by the manager.
     *
     * @return UserRepository
     */
    public function getEntityRepository()
    {
        return $this->repository;
    }
}
