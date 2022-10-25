<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception;

class InvalidUuidException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'UUID_INVALID';
    }

    public static function byValue(string $value): static
    {
        return new static(sprintf('The value %s is a uuid format invalid', $value));
    }
}
