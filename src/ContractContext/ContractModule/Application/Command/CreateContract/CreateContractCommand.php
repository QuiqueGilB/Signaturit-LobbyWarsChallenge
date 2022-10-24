<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract;

use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class CreateContractCommand extends Command
{
    /** @var ParticipantData[] */
    public readonly array $participants;

    public function __construct(
        public readonly Uuid $contractId,
        ParticipantData ...$participants
    ) {
        $this->participants = $participants;
    }

}
