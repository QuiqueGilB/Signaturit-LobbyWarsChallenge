<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\EventBus;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandBus;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\EventBus;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\MiddlewareService;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;

class DomainEventBus implements EventBus
{
    private $next;

    public function __construct(MiddlewareService $middlewareService, Middleware ...$middlewares)
    {
        $this->next = $middlewareService->mount(...$middlewares);
    }

    public function dispatch(DomainEvent $event): void
    {
        call_user_func($this->next, $event);
    }
}
