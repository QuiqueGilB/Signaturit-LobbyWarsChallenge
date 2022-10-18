<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model;

use DateTimeImmutable;

abstract class Aggregate
{
    public readonly DateTimeImmutable $createdAt;
    public readonly DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }
}
