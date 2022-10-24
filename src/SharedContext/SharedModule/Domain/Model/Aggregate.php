<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model;

use DateTimeImmutable;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

abstract class Aggregate
{
    protected readonly DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;

    public function __construct(protected Uuid $id)
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
