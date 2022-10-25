<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model;

use DateTimeImmutable;

trait Deletable
{
    private ?DateTimeImmutable $deletedAt;

    public function delete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
    }

    public function isDeleted(): bool
    {
        return !is_null($this->deletedAt) && $this->deletedAt < new DateTimeImmutable();
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
