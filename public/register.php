<?php

use Authentication\Entity\User;
use Infrastructure\Authentication\Repository\DoctrineBlogPosts;
use Infrastructure\Authentication\Repository\FilesystemUsers;

require_once  __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$existingUsers = $users = new DoctrineBlogPosts(
    $entityManager,
    $entityManager->getRepository(User::class)
);
$passwordHashMechanism = function (string $password) : string {
    return password_hash($password, \PASSWORD_DEFAULT);
};
$emailNotificationSender = function (string $emailAddress) : void {
   error_log(sprintf('Registered "%s"', $emailAddress));
};

$users->store(User::register(
    $_POST['emailAddress'],
    $_POST['password'],
    $existingUsers,
    $passwordHashMechanism,
    $emailNotificationSender
));

echo 'OK';
