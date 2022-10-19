<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ContractHasNotWinnersException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'CONTRACT_HAS_NOT_WINNERS';
    }

    public static function zero(Uuid $id): self
    {
        return new self(sprintf("The contract %s has zero winners", $id));
    }

    public static function many(Uuid $id): self
    {
        return new self(sprintf("The contract %s has many winners and can not resolve", $id));
    }
}
