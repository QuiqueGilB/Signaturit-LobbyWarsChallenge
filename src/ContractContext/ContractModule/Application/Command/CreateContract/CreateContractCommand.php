<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class CreateContractCommand extends Command
{
    /** @var Participant[] */
    public readonly array $participants;

    public function __construct(
        public readonly Uuid $contractId,
        Participant ...$participants
    ) {
        $this->participants = $participants;
    }

}
