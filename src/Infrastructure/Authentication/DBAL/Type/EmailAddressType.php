<?php

namespace Infrastructure\Authentication\DBAL\Type;

use Authentication\EmailAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class EmailAddressType extends StringType
{
    public function getDefaultLength(AbstractPlatform $platform) : int
    {
        return 1024;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) : string
    {
        if (! $value instanceof EmailAddress) {
            throw new \InvalidArgumentException(sprintf('Expected "%s", got "%s"', EmailAddress::class, is_object($value) ? get_class($value) : gettype($value)));
        }

        return parent::convertToDatabaseValue($value->toString(), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : EmailAddress
    {
        return EmailAddress::fromEmail(parent::convertToPHPValue($value, $platform));
    }

    public function getName()
    {
        return self::class;
    }
}
