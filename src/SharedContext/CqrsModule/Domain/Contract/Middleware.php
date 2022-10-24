<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

interface Middleware
{
    public function __invoke($think, callable $next);
}
