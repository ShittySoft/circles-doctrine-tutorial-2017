<?php

namespace BlogPost\Repository;

use BlogPost\Entity\BlogPost;
use Ramsey\Uuid\UuidInterface;

interface BlogPosts
{
    public function get(UuidInterface $id) : BlogPost;
    public function store(BlogPost $post) : void;
}
