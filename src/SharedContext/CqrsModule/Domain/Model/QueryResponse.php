<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model;

class QueryResponse
{
    public function __construct(
        public readonly array $data,
        public readonly QueryMetadata $metadata
    ) {
    }
}
