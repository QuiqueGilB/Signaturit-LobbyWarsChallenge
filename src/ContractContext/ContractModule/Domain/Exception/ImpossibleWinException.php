<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception;

use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;

class ImpossibleWinException extends DomainException
{
    public static function domainErrorCode(): string
    {
        return 'IMPOSSIBLE_WIN';
    }

    public static function onlyOnceSignature(int $score, Signature ...$signatures): static
    {
        return new static(sprintf(
            'It is impossible to win with only one signature to %s score with the signatures [%s]',
            $score,
            implode(', ', $signatures)
        ));
    }

}
