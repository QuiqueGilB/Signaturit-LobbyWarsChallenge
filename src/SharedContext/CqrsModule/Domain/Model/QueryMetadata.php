<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model;

class QueryMetadata
{
    public function __construct(
        public readonly int $results,
        public readonly int $total,
        public readonly int $limit,
        public readonly int $offset,
    ) {
    }
}
