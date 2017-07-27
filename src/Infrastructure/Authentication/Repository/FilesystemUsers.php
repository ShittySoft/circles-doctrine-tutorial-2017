<?php

namespace Infrastructure\Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;

final class FilesystemUsers implements Users
{
    /**
     * @var string
     */
    private $usersDirectory;

    public function __construct(string $usersDirectory)
    {
        $this->usersDirectory = $usersDirectory;
    }

    public function has(string $emailAddress) : bool
    {
        return file_exists($this->usersDirectory . '/' . $emailAddress);
    }

    public function get(string $emailAddress) : User
    {
        return unserialize(file_get_contents($this->usersDirectory . '/' . $emailAddress));
    }

    public function store(User $user) : void
    {
        $reflectionEmailAddress = new \ReflectionProperty($user, 'emailAddress');

        $reflectionEmailAddress->setAccessible(true);

        file_put_contents(
            $this->usersDirectory . '/' . $reflectionEmailAddress->getValue($user),
            serialize($user)
        );
    }
}