<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;

class InvalidEventNameException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'INVALID_EVENT_NAME';
    }

    public static function byContext(string $context): self
    {
        return new self(sprintf("The context (%s) of event name required end with 'Context'", $context));
    }

    public static function byModule(string $module): self
    {
        return new self(sprintf("The module (%s) of event name required end with 'Module'", $module));
    }
    public static function byVersion(string $version): self
    {
        return new self(sprintf("The version (%s) of event name required format \^v\d+\$\\", $version));
    }

}
