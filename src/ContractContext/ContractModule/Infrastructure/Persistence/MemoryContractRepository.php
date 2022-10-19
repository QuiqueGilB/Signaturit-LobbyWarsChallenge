<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Persistence;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class MemoryContractRepository implements ContractRepository
{
    /** @var Contract[] */
    private array $storage;

    public function save(Contract $contract): void
    {
        $this->storage[$contract->id()->value] = $contract;
    }

    public function byId(Uuid $id): ?Contract
    {
        return $this->storage[$id->value] ?? null;
    }
}
