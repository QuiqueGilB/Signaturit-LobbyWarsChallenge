<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\EventBus\Middleware;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;

class CommandHandlerInvokerMiddleware implements Middleware
{
    /** @var CommandHandler[] */
    private array $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function __invoke($think, callable $next)
    {
        return $next($this->handlers[0]($think));
    }


}
