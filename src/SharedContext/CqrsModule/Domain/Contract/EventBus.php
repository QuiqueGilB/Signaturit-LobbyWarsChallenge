<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;

interface EventBus
{
    public function dispatch(DomainEvent $event): void;
}
