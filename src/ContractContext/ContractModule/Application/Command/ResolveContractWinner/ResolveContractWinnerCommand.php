<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ResolveContractWinnerCommand extends Command
{
    public function __construct(public readonly Uuid $contractId)
    {
    }
}
