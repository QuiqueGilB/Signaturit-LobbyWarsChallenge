<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\CommandBus;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandBus;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Service\MiddlewareService;

class DomainCommandBus implements CommandBus
{
    private $next;

    public function __construct(MiddlewareService $middlewareService, Middleware ...$middlewares)
    {
        $this->next = $middlewareService->mount(...$middlewares);
    }

    public function handle(Command $command): void
    {
        call_user_func($this->next, $command);
    }
}
