<?php

use Authentication\EmailAddress;
use Authentication\Entity\User;
use Infrastructure\Authentication\Repository\DoctrineUsers;

require_once  __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$existingUsers = $users = new DoctrineUsers(
    $entityManager,
    $entityManager->getRepository(User::class)
);
$passwordHashMechanism = function (string $password) : string {
    return password_hash($password, \PASSWORD_DEFAULT);
};
$emailNotificationSender = function (EmailAddress $emailAddress) : void {
   error_log(sprintf('Registered "%s"', $emailAddress->toString()));
};

$users->store($user = User::register(
    EmailAddress::fromEmail($_POST['emailAddress']),
    $_POST['password'],
    $existingUsers,
    $passwordHashMechanism,
    $emailNotificationSender
));

var_dump($user);
echo 'OK';
