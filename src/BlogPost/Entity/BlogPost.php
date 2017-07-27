<?php

namespace BlogPost\Entity;

use Authentication\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class BlogPost
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
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $contents;

    /**
     * @var Collection|Comment[]
     */
    private $comments;

    private function __construct(User $author, string $title, string $contents)
    {
        $this->id       = Uuid::uuid4()->toString();
        $this->author   = $author;
        $this->title    = $title;
        $this->contents = $contents;
        $this->comments = new ArrayCollection();
    }

    public static function publish(User $author, string $title, string $contents) : self
    {
        return new self($author, $title, $contents);
    }

    public function comment(User $commenter, string $comment, \DateTime $currentTime) : void
    {
        $this->comments[] = Comment::post($this, $commenter, $comment, clone $currentTime);
    }

    public function getId() : string
    {
        return $this->id;
    }
}
