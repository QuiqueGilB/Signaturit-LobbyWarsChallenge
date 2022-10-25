<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Signaturit\LobbyWarsChallenge\Tests\Shared\SharedTestTrait;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Test;

abstract class BaseUnitTest extends TestCase implements Test
{
    use SharedTestTrait;
}
