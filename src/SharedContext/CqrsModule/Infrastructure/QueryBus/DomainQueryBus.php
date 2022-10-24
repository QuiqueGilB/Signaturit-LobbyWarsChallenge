<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Infrastructure\QueryBus;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\Middleware;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\QueryBus;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\MiddlewareService;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Query;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryResponse;

class DomainQueryBus implements QueryBus
{
    private $next;

    public function __construct(MiddlewareService $middlewareService, Middleware ...$middlewares)
    {
        $this->next = $middlewareService->mount(...$middlewares);
    }

    public function ask(Query $query): QueryResponse
    {
        return call_user_func($this->next, $query);
    }
}
