<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model;

abstract class QueryResponse
{
    public function __construct(
        public readonly QueryData $data,
        public readonly QueryMetadata $metadata
    ) {
    }
}
