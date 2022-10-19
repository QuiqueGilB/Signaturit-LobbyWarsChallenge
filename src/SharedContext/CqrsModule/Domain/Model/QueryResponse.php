<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model;

class QueryResponse
{
    public function __construct(
        public readonly mixed $data,
        public readonly QueryMetadata $metadata
    ) {
    }
}
