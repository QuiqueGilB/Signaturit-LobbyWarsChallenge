<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Unit\src\ContractContext\ContractModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\Tests\Shared\BaseUnitTest;

/** @covers \Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService */
class ResolveSignatureScoresServiceTest extends BaseUnitTest
{
    private readonly ResolveSignatureScoresService $resolveSignatureScoresService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolveSignatureScoresService = new ResolveSignatureScoresService();
    }

    /** @dataProvider stage */
    public function testAccumulateScore(int $score, array $signatures): void
    {
        self::assertEquals($score, $this->resolveSignatureScoresService->acumulate(...$signatures));
    }

    public function stage(): iterable
    {
        yield 'one king' => [5, [Signature::King]];
        yield 'one notary' => [2, [Signature::Notary]];
        yield 'one validator' => [1, [Signature::Validator]];
        yield 'one unknown' => [0, [Signature::Unknown]];
        yield 'king-notary' => [7, [Signature::King, Signature::Notary]];
        yield 'king-notary-validator' => [7, [Signature::King, Signature::Notary, Signature::Validator]];
        yield 'king-unknown-validator' => [5, [Signature::King, Signature::Unknown, Signature::Validator]];
        yield 'validator-notary' => [3, [Signature::Validator, Signature::Notary]];
    }
}
