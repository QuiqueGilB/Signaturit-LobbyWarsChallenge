<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Model\WithEvents;

abstract class AggregateRoot extends Aggregate
{
    use WithEvents;
}
