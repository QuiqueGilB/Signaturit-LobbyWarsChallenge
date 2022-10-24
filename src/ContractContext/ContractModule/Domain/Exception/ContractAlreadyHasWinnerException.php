<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ContractAlreadyHasWinnerException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'CONTRACT_ALREADY_HAS_WINNER_ERROR';
    }

    public static function hasAlready(Uuid $contractId): static
    {
        return new static(sprintf('The contract %s already has a winner', $contractId));
    }
}
