<?php

use Infrastructure\Authentication\Repository\FilesystemUsers;

require_once  __DIR__ . '/../vendor/autoload.php';

$existingUsers = $users = new FilesystemUsers(__DIR__ . '/../data/users');
$passwordHashMechanism = function (string $password) : string {
    return password_hash($password, \PASSWORD_DEFAULT);
};
$emailNotificationSender = function (string $emailAddress) : void {
   error_log(sprintf('Registered "%s"', $emailAddress));
};

$users->store(\Authentication\Entity\User::register(
    $_POST['emailAddress'],
    $_POST['password'],
    $existingUsers,
    $passwordHashMechanism,
    $emailNotificationSender
));

echo 'OK';
