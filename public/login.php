<?php

use Infrastructure\Authentication\Repository\FilesystemUsers;

require_once  __DIR__ . '/../vendor/autoload.php';

$existingUsers = $users = new FilesystemUsers(__DIR__ . '/../data/users');

$user = $existingUsers->get($_POST['emailAddress']);

$user->login($_POST['password'], 'password_verify');

echo 'OK';