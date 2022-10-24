<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ParticipantData
{
    public function __construct(
        public readonly ?Uuid $participantId,
        public readonly array $signatures,
    ) {
    }
}
