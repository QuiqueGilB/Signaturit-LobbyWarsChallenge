<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Query;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class FindContractQuery extends Query
{
    public function __construct(public readonly Uuid $contractId)
    {
    }
}
