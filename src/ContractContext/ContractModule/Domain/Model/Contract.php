<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model;

use DateTimeImmutable;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model\AggregateRoot;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class Contract extends AggregateRoot
{
    /** @var Participant[] */
    public readonly array $participants;
    public readonly ?Participant $winner;

    public function __construct(Uuid $id, Participant ...$participants)
    {
        parent::__construct($id);
        $this->participants = $participants;
    }

    public function update(Participant $winner): void
    {
        $this->doUpdate($winner);
    }

    private function doUpdate(Participant $winner): void
    {
        $this->winner = $winner;
        $this->updatedAt = new DateTimeImmutable();
    }
}
