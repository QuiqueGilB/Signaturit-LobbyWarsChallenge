<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

interface Middleware
{
    public function __invoke($think, callable $next);
}
