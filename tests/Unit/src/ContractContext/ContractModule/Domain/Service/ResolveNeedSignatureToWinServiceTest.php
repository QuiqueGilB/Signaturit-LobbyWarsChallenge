<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Unit\src\ContractContext\ContractModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveNeedSignatureToWinService;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\Tests\Shared\BaseUnitTest;

/** @covers \Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveNeedSignatureToWinService */
class ResolveNeedSignatureToWinServiceTest extends BaseUnitTest
{
    private readonly ResolveNeedSignatureToWinService $needSignatureToWinService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->needSignatureToWinService = new ResolveNeedSignatureToWinService(new ResolveSignatureScoresService());
    }

    /** @dataProvider stage */
    public function testNeedToWin(array $signatureToWinExpect, int $score, array $signatures): void
    {
        $signaturesToWin = $this->needSignatureToWinService->needToWin($score, ...$signatures);
        self::assertEquals($signatureToWinExpect, $signaturesToWin);
    }

    public function stage(): iterable
    {
        yield 'need many' => [[Signature::King, Signature::Notary], 7, [Signature::Notary]];
        yield 'only need one' => [[Signature::Notary], 5, [Signature::King]];
        yield 'is already winner' => [[], 1, [Signature::Notary]];
    }
}
