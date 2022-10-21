<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ImpossibleCalculateSignatureForWinContractException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'IMPOSSIBLE_CALCULATE_SIGN_FOR_WIN';
    }

    static function manyUnknowns(Uuid $contractId): static
    {
        return new static(sprintf(
            'The contract #%s is impossible to solve because it has many unknown signatures',
            $contractId
        ));
    }
}
