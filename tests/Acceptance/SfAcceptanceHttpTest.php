<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Acceptance;

use Signaturit\LobbyWarsChallenge\Tests\Shared\SharedTestTrait;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class SfAcceptanceHttpTest extends KernelTestCase implements Test
{
    use SharedTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    protected function submitRequest(Request $request): Response
    {
        return self::$kernel->handle($request);
    }

    protected static function assertEndpointExists(Response $response): void
    {
        self::assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertNotEquals(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
    }
}
