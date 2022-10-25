<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Query;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryResponse;

/** @method QueryResponse __invoke(Query $query) */
interface QueryHandler
{
}
