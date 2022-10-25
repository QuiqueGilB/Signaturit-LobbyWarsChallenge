<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Shared;

use Throwable;

trait SharedTestTrait
{
    protected static function callIgnoringErrors(callable $fn, ...$arguments): CallFunctionCapsule
    {
        try {
            return new CallFunctionCapsule($fn(...$arguments), null);
        } catch (Throwable $throwable) {
            return new CallFunctionCapsule(null, $throwable);
        }
    }
}
