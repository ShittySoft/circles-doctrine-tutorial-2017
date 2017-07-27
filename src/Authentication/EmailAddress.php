<?php

namespace Authentication;

final class EmailAddress
{
    /**
     * @var string
     */
    private $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function fromEmail(string $email) : self
    {
        if (! filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('Invalid email "%s" provided', $email));
        }
        return new self($email);
    }

    public function toString() : string
    {
        return $this->email;
    }

    public function __toString() : string
    {
        return $this->email;
    }
}
