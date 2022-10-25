<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ContractHasNotWinnerException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'CONTRACT_WINNER_ERROR';
    }

    public static function unresolved(Uuid $contractId): static
    {
        return new static(sprintf('The contract %s has not winner', $contractId));
    }
}
