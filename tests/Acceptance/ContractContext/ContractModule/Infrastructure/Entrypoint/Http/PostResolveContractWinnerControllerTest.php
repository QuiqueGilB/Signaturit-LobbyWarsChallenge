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

    public function stage(): iterable
    {
        $endpoint = '/contract/winner';
        $method = 'POST';

        yield 'abc' => [Request::create(uri: $endpoint, method: $method, content: ["KV","N"])];
    }
}
