<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\CanNotResolveNeedSignaturesToWinException;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;

class ResolveNeedSignatureToWinService
{
    public function __construct(private readonly ResolveSignatureScoresService $resolveSignatureScoresService)
    {
    }

    /** @return Signature[] */
    public function needToWin(int $maxScore, Signature ...$signatures): array
    {
        if ($maxScore < $this->resolveSignatureScoresService->acumulate(...$signatures)) {
            return [];
        }

        $signaturesSorted = Signature::cases();
        usort($signaturesSorted, static fn(Signature $a, Signature $b) => $a->score() <=> $b->score());

        /** @var Signature[] $needToWin */
        $needToWin = [];
        while (true) {
            foreach ($signaturesSorted as $signature) {
                if ($maxScore < $this->resolveSignatureScoresService->acumulate($signature, ...$needToWin, ...$signatures)) {
                    return [...$needToWin, $signature];
                }
            }
            isset($signature) && $needToWin[] = $signature;
        }
    }
}
