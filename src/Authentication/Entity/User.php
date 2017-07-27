<?php

namespace Authentication\Entity;

use Authentication\Repository\Users;
use Ramsey\Uuid\Uuid;

class User
{
    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $passwordHash;

    private function __construct(string $emailAddress, string $passwordHash)
    {
        $this->emailAddress = $emailAddress;
        $this->passwordHash = $passwordHash;
    }

    public static function register(
        string $emailAddress,
        string $password,
        Users $existingUsers,
        callable $hashingMechanism,
        callable $emailNotifier
    ) : self {
        if ($existingUsers->has($emailAddress)) {
            throw new \DomainException(sprintf('User "%s" already exists', $emailAddress));
        }

        // @TODO validate email address? here? where?

        $user = new self($emailAddress, $hashingMechanism($password));

        $emailNotifier($emailAddress);

        return $user;
    }

    public function login(string $password, callable $passwordVerificationMechanism) : void
    {
        if (! $passwordVerificationMechanism($password, $this->passwordHash)) {
            throw new \DomainException(sprintf('Authentication failed for "%s"', $this->emailAddress));
        }
    }
}
