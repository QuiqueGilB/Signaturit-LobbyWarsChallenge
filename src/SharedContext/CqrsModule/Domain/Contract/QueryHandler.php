<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryResponse;

interface QueryHandler
{
    public function __invoke(Command $command): QueryResponse;
}
