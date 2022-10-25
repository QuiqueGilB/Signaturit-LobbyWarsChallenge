<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\CommandBus\Middleware;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\EventBus;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Service\EventCollector;

class DispatchEventsOccurredMiddleware implements Middleware
{
    public function __construct(private readonly EventBus $eventBus)
    {
    }

    public function __invoke($think, callable $next)
    {
        EventCollector::instance()->purge();
        $result = $next($think);
        $events = EventCollector::instance()->pull();
        array_walk($events, [$this->eventBus, 'dispatch']);

        return $result;
    }
}
