<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContractParticipants;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Query;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class FindContractParticipantsQuery extends Query
{
    public function __construct(public readonly Uuid $contractId)
    {
    }
}
