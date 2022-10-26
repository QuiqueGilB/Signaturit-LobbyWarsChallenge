<?php

namespace Signaturit\LobbyWarsChallenge\Tests\Acceptance\src\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Signaturit\LobbyWarsChallenge\Tests\Acceptance\SfAcceptanceHttpTest;
use Symfony\Component\HttpFoundation\Request;

class PostResolveNeedToWinControllerTest extends SfAcceptanceHttpTest
{
    /** @dataProvider stage */
    public function testExistEndpoint(Request $request): void
    {
        $response = $this->submitRequest($request);
        self::assertEndpointExists($response);
    }

    /** @dataProvider stage */
    public function testStatusCode(Request $request): void
    {
        $response = $this->submitRequest($request);
        self::assertEquals(201, $response->getStatusCode());
    }

    /** @dataProvider stage */
    public function testSchemaOfResponse(Request $request): void
    {
        $signatures = explode(' ', $request->getContent());
        $response = $this->submitRequest($request);
        foreach ($signatures as $signature) {
            self::assertStringContainsString($signature . ': ', $response->getContent());
        }
    }

    public function stage(): iterable
    {
        $endpoint = '/contract/need-to-win';
        $method = 'POST';

        yield 'good request' => [Request::create(uri: $endpoint, method: $method, content: 'N V#')];

    }
}
