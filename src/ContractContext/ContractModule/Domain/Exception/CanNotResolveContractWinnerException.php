<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class CanNotResolveContractWinnerException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'CAN_NOT_RESOLVE_CONTRACT_WINNER_ERROR';
    }

    public static function zero(Uuid $contractId): self
    {
        return new self(sprintf('The contract %s has zero winners', $contractId));
    }

    public static function many(Uuid $contractId): self
    {
        return new self(sprintf('The contract %s has many winners and can not resolve', $contractId));
    }
}
