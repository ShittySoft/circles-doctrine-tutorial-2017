<?php

namespace Blog\Entity;

use Authentication\Entity\User;
use Ramsey\Uuid\Uuid;

class Comment
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var User
     */
    private $author;

    /**
     * @var BlogPost
     */
    private $blogPost;

    /**
     * @var string
     */
    private $contents;

    /**
     * @var \DateTime
     */
    private $dateTime;

    private function __construct(string $id, User $author, BlogPost $blogPost, string $contents, \DateTime $dateTime)
    {
        $this->id       = $id;
        $this->author   = $author;
        $this->blogPost = $blogPost;
        $this->contents = $contents;
        $this->dateTime = $dateTime;
    }

    public static function post(User $author, BlogPost $blogPost, string $contents, \DateTime $dateTime) : self
    {
        return new self((string) Uuid::uuid4(), $author, $blogPost, $contents, clone $dateTime);
    }

    public function getContents() : string
    {
        return $this->contents;
    }
}
