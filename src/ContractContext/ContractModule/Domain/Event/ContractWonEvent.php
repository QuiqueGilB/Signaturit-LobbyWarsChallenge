<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ContractWonEvent extends ContractEvent
{
    public readonly Uuid $winnerParticipantId;
    public readonly int $winnerScore;

    public function __construct(Contract $contract)
    {
        parent::__construct($contract);
        $this->winnerParticipantId = $contract->winner()?->id();
        $this->winnerScore = $contract->winner()?->score();
    }
}
