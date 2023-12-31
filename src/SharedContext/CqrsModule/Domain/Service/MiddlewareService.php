<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;

class MiddlewareService
{
    public function mount(Middleware ...$middlewares): callable
    {
        $action = static fn($think) => $think;
        foreach ($middlewares as $middleware) {
            $action = static fn($think) => $middleware($think, $action);
        }
        return $action;
    }
}
