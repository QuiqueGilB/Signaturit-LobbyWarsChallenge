<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\CommandBus\Middleware;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Traversable;

class CommandInvokerMiddleware implements Middleware
{
    /** @var CommandHandler[] */
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers instanceof Traversable ? iterator_to_array($handlers) : $handlers;
    }

    public function __invoke($think, callable $next)
    {
        ($this->handlers[get_class($think) . 'Handler'])($think);
        $next($think);
    }
}
