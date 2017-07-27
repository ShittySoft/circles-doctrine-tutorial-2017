<?php

namespace BlogPost\Repository;

use BlogPost\Entity\BlogPost;

interface BlogPosts
{
    public function store(BlogPost $post) : void;
}
