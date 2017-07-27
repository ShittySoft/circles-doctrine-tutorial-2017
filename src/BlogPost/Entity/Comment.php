<?php

namespace BlogPost\Entity;

use Authentication\Entity\User;
use Ramsey\Uuid\Uuid;

class Comment
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var BlogPost
     */
    private $blogPost;

    /**
     * @var User
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $time;

    private function __construct(
        BlogPost $blogPost,
        User $author,
        string $content,
        \DateTime $time
    )
    {
        $this->id       = Uuid::uuid4()->toString();
        $this->blogPost = $blogPost;
        $this->author   = $author;
        $this->content  = $content;
        $this->time     = $time;
    }

    public static function post(
        BlogPost $blogPost,
        User $author,
        string $content,
        \DateTime $time
    ) : self {
        return new self($blogPost, $author, $content, clone $time);
    }
}
