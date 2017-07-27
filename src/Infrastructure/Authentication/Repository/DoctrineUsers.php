<?php

namespace Infrastructure\Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;

final class DoctrineUsers implements Users
{
    /**
     * @var string
     */
    private $usersDirectory;

    /**
     * @var ObjectManager
     */
    private $persistenceManager;

    /**
     * @var ObjectRepository
     */
    private $repository;

    public function __construct(ObjectManager $persistenceManager, ObjectRepository $repository)
    {
        $this->persistenceManager = $persistenceManager;
        $this->repository = $repository;
    }

    public function has(string $emailAddress) : bool
    {
        return (bool) $this->repository->find($emailAddress);
    }

    public function get(string $emailAddress) : User
    {
        return $this->repository->find($emailAddress);
    }

    public function store(User $user) : void
    {
        $this->persistenceManager->persist($user);
        $this->persistenceManager->flush();
    }
}