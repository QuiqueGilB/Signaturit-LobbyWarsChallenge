<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\EventBus\Middleware;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Service\EventCollector;

class DispatchEventsMiddleware implements Middleware
{
    public function __construct()
    {
    }

    public function __invoke($think, callable $next)
    {
        EventCollector::instance()->purge();
        $result = $next($think);
        $events = EventCollector::instance()->pull();


        return $result;
    }
}
