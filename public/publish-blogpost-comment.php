<?php

use Authentication\Entity\User;
use BlogPost\Entity\BlogPost;
use Infrastructure\Authentication\Repository\DoctrineUsers;
use Infrastructure\BlogPost\Repository\DoctrineBlogPosts;
use Ramsey\Uuid\Uuid;

require_once  __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new DoctrineUsers(
    $entityManager,
    $entityManager->getRepository(User::class)
);
$blogPosts = new DoctrineBlogPosts(
    $entityManager
);
$entityManager->transactional(function () use ($blogPosts, $users) {
    $blogPost = $blogPosts->get(Uuid::fromString($_POST['blogPostId']));
    $blogPost->comment(
        $users->get($_POST['emailAddress']),
        $_POST['contents'],
        new \DateTime()
    );
    $blogPosts->store($blogPost);
});

echo 'OK';
