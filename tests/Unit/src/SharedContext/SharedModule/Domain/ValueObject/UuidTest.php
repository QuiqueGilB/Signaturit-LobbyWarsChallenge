<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Unit\src\SharedContext\SharedModule\Domain\ValueObject;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\InvalidUuidException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\Tests\Shared\BaseUnitTest;

/** @covers \Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid */
class UuidTest extends BaseUnitTest
{
    /** @dataProvider stage */
    public function testValidUuid(string $uuid, bool $isValid): void
    {
        $isValid ? $this->expectNotToPerformAssertions() : $this->expectException(InvalidUuidException::class);
        new Uuid($uuid);
    }

    /** @dataProvider stage */
    public function testToString(string $uuid, bool $isValid): void
    {
        if (!$isValid) {
            $this->expectNotToPerformAssertions();
            return;
        }
        self::assertEquals($uuid, (string)(new Uuid($uuid)));
    }

    public function stage(): iterable
    {
        yield 'valid from string' => ['fbdd63aa-3f1f-4138-b04f-ef06f5411eac', true];
        yield 'invalid from string' => ['fake uuid', false];
        yield 'created from v4' => [Uuid::v4()->value, true];
    }
}
