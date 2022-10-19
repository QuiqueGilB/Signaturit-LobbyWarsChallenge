<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model\AggregateRoot;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class Contract extends AggregateRoot
{
    /** @var Participant[] */
    public readonly array $participants;

    public function __construct(Uuid $id, Participant ...$participants)
    {
        parent::__construct($id);
        $this->participants = $participants;
    }
}
