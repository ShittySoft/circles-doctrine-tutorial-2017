<?php

namespace Infrastructure\BlogPost\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use BlogPost\Entity\BlogPost;
use BlogPost\Repository\BlogPosts;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;

final class DoctrineBlogPosts implements BlogPosts
{
    /**
     * @var ObjectManager
     */
    private $persistenceManager;

    public function __construct(ObjectManager $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    public function store(BlogPost $post) : void
    {
        $this->persistenceManager->persist($post);
        $this->persistenceManager->flush();
    }
}