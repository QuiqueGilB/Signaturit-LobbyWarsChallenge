<?php

namespace Signaturit\LobbyWarsChallenge\Tests\Acceptance\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Signaturit\LobbyWarsChallenge\Tests\Acceptance\SfAcceptanceHttpTest;
use Symfony\Component\HttpFoundation\Request;

class PostResolveContractWinnerControllerTest extends SfAcceptanceHttpTest
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
        self::assertContainsEquals($response->getContent(), $signatures);
    }

    public function stage(): iterable
    {
        $endpoint = '/contract/winner';
        $method = 'POST';

        yield 'abc' => [Request::create(uri: $endpoint, method: $method, content: ["KV","N"])];
    }
}
