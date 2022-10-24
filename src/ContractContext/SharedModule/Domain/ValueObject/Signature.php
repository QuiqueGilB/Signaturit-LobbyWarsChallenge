<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject;

enum Signature: string
{
    case King = 'K';
    case Notary = 'N';
    case Validator = 'V';
    case Unknown = '#';

    public function score(): int
    {
        return match ($this) {
            self::King => 5,
            self::Notary => 2,
            self::Validator => 1,
            self::Unknown => 0
        };
    }
}
