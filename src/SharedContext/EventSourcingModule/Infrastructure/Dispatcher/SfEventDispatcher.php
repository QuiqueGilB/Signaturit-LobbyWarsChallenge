<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Infrastructure\Dispatcher;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Contract\EventDispatcher;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;

class SfEventDispatcher implements EventDispatcher
{
    public function __construct(private readonly SymfonyEventDispatcher $eventDispatcher)
    {
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->eventDispatcher->dispatch($event, $event->eventName->fqn());
    }
}
