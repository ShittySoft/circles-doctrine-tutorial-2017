<?php

namespace Authentication;

final class PasswordHash
{
    /**
     * @var string
     */
    private $hash;

    private function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public static function fromPasswordAndHashingAlgo(string $password, callable $hashingAlgo) : self
    {
        return self::fromHash($hashingAlgo($password));
    }

    public static function fromHash(string $hash) : self
    {
        if (0 !== strpos($hash, '$2y')) {
            throw new \InvalidArgumentException(sprintf('Invalid hash provided'));
        }

        return new self($hash);
    }

    public function matches(string $password) : bool
    {
        return password_verify($password, $this->hash);
    }

    public function toString() : string
    {
        return $this->hash;
    }
}
