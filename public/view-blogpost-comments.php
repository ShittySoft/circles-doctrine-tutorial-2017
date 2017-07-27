<?php

use Authentication\Entity\User;
use Blog\Entity\BlogPost;
use Infrastructure\Authentication\Repository\DoctrineUsers;
use Infrastructure\Blog\Repository\DoctrineBlogPosts;
use Ramsey\Uuid\Uuid;

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$blogPosts = new DoctrineBlogPosts($entityManager, $entityManager->getRepository(BlogPost::class));

$entityManager->getRepository(User::class)->find('foo@example.com');
//$blogPost = $blogPosts->get(Uuid::fromString($_GET['blogPostId']));
//
//var_dump($blogPost->getCommentTexts());

$statistics = $entityManager->getConfiguration()->getSecondLevelCacheConfiguration()->getCacheLogger();

var_dump([
    'hit' => $statistics->getHitCount(),
    'miss' => $statistics->getMissCount(),
    'put' => $statistics->getPutCount(),
]);
