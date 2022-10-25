<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data;

use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

/** @property Signature[] $signatures */
class ParticipantData
{
    public function __construct(
        public readonly ?Uuid $participantId,
        public readonly array $signatures,
    ) {
    }
}
