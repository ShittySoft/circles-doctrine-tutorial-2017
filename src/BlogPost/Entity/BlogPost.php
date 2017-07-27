<?php

namespace BlogPost\Entity;

use Authentication\Entity\User;
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

    private function __construct(User $author, string $title, string $contents)
    {
        $this->id       = Uuid::uuid4()->toString();
        $this->author   = $author;
        $this->title    = $title;
        $this->contents = $contents;
    }

    public static function publish(User $author, string $title, string $contents) : self
    {
        return new self($author, $title, $contents);
    }

    public function getId() : string
    {
        return $this->id;
    }
}
