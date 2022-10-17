<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception;

use Exception;

abstract class DomainException extends Exception
{
    final protected function __construct(string $message)
    {
        parent::__construct($message, 1);
    }

    abstract public static function domainErrorCode(): string;
}
