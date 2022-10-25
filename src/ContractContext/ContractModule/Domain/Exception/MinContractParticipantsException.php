<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class MinContractParticipantsException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'MIN_CONTRACT_PARTICIPANTS_ERROR';
    }

    public static function byId(Uuid $contractId, int $min): static
    {
        return new static(sprintf('Contract %s required minimum %s participants', $contractId, $min));
    }


}
