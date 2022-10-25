<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\EventBus\Middlewares;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Contract\EventDispatcher;

class DispatchEventMiddleware implements Middleware
{
    public function __construct(private readonly EventDispatcher $eventDispatcher)
    {
    }

    public function __invoke($think, callable $next)
    {
        $this->eventDispatcher->dispatch($think);
        return $next($think);
    }
}
