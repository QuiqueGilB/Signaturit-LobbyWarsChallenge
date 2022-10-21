<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ContractWinnerException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'CONTRACT_WINNER_ERROR';
    }

    public static function hasAlready(Uuid $contratId):static {
        return new static(sprintf(''));
    }

    

}
