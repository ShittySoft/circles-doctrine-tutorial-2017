<?php

use Authentication\Entity\User;
use Infrastructure\Authentication\Repository\DoctrineUsers;

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManager */
$entityManager = require __DIR__ . '/../bootstrap.php';

$users = new DoctrineUsers($entityManager, $entityManager->getRepository(User::class));

$users->store(User::register($_POST['emailAddress'], $_POST['password'], $users, function (string $password) : string {
    return password_hash($password, \PASSWORD_DEFAULT);
}));

var_dump($users->get($_POST['emailAddress']));
