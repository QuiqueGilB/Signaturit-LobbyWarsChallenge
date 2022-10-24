<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\CanNotResolveNeedSignaturesToWinException;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;

class ResolveNeedSignatureToWinService
{
    public function __construct(private readonly ResolveSignatureScoresService $resolveSignatureScoresService)
    {
    }

    /**
     * TODO: Calculate many signatures
     * @return Signature[]
     */
    public function needToWin(int $maxScore, Signature ...$signatures): array
    {
        $signaturesSorted = Signature::cases();
        usort($signaturesSorted, static fn(Signature $a, Signature $b) => $a->score() <=> $b->score());

        foreach ($signaturesSorted as $signature) {
            if ($maxScore < $this->resolveSignatureScoresService->acumulate($signature, ...$signatures)) {
                return [$signature];
            }
        }

        throw CanNotResolveNeedSignaturesToWinException::onlyOnceSignature($maxScore, ...$signatures);
    }
}
