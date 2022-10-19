<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ContractNotFoundException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'CONTRACT_NOT_FOUND';
    }

    public static function byId(Uuid $id): static
    {
        return new static(sprintf("Contract with id %s not found", $id->value));
    }
}
