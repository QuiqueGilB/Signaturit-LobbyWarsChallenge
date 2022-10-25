<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Shared;

use PHPUnit\Framework\TestCase;

abstract class BaseUnitTest extends TestCase implements Test
{
    use SharedTestTrait;
}
