<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Shared;

use Throwable;

class CallFunctionCapsule
{
    public function __construct(public readonly mixed $result, public readonly ?Throwable $throwable)
    {
    }

    public function isSuccessful(): bool
    {
        return !$this->hasErrorOccurred();
    }

    public function hasErrorOccurred(): bool
    {
        return !is_null($this->throwable);
    }
}
