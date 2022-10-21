<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event;

use DateTimeImmutable;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

abstract class ContractEvent extends DomainEvent
{
    public readonly Uuid $contractId;
    public readonly DateTimeImmutable $updatedAt;
    public readonly DateTimeImmutable $createdAt;

    public function __construct(Contract $contract)
    {
        parent::__construct();
        $this->contractId = $contract->id();
        $this->updatedAt = $contract->updatedAt();
        $this->createdAt = $contract->createdAt();
    }

    protected static function context(): string
    {
        return 'contractContext';
    }

    protected static function module(): string
    {
        return 'contractModule';
    }

    protected static function resource(): string
    {
        return 'contract';
    }


}
