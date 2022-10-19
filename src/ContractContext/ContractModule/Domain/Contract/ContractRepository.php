<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

interface ContractRepository
{
    public function save(Contract $contract): void;

    public function byId(Uuid $id): ?Contract;
}
