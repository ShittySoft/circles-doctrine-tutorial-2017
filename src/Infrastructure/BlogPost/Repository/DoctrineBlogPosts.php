<?php

namespace Infrastructure\BlogPost\Repository;

use BlogPost\Entity\BlogPost;
use BlogPost\Repository\BlogPosts;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\UuidInterface;

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

    public function get(UuidInterface $id) : BlogPost
    {
        return $this->persistenceManager->find(BlogPost::class, $id->toString());
    }

    public function store(BlogPost $post) : void
    {
        $this->persistenceManager->persist($post);
        $this->persistenceManager->flush();
    }
}