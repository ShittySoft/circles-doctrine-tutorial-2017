<?php

use Authentication\Entity\User;
use BlogPost\Entity\BlogPost;
use Infrastructure\Authentication\Repository\DoctrineUsers;
use Infrastructure\BlogPost\Repository\DoctrineBlogPosts;

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

$blogPosts->store(BlogPost::publish(
    $users->get($_POST['emailAddress']),
    $_POST['title'],
    $_POST['contents']
));

echo 'OK';
