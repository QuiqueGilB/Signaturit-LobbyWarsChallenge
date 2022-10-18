<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Service\EventCollector;

trait WithEvents
{
    protected function record(DomainEvent $event): void
    {
        EventCollector::instance()->publish($event);
    }
}
