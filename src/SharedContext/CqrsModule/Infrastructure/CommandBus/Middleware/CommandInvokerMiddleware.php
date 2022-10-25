<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\CommandBus\Middleware;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;

class CommandInvokerMiddleware implements Middleware
{
    /** @var CommandHandler[] */
    private array $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function __invoke($think, callable $next)
    {
        return $next($this->handlers[get_class($think)]($think));
    }
}
