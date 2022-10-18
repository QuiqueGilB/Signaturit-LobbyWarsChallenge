<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event;

use DateTimeImmutable;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    public readonly Uuid $eventId;
    public readonly DateTimeImmutable $occurredOn;

    public function __construct()
    {
        $this->eventId = Uuid::v4();
        $this->occurredOn = new DateTimeImmutable();
    }

}
