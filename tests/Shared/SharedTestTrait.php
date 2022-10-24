<?php

namespace Signaturit\LobbyWarsChallenge\Tests\Shared;

use Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\CallFunctionCapsule;
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
