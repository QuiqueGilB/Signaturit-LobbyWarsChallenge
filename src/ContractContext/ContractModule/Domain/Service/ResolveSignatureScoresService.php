<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ImpossibleWinException;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;

class ResolveSignatureScoresService
{
    public function acumulate(Signature ...$signatures): int
    {
        $hasKing = in_array(Signature::King, $signatures);

        return array_sum(array_map(
            static fn(Signature $signature) => $hasKing && Signature::Validator === $signature
                ? 0
                : $signature->score(),
            $signatures
        ));
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
            if ($maxScore < $this->acumulate($signature, ...$signatures)) {
                return [$signature];
            }
        }

        throw ImpossibleWinException::onlyOnceSignature($maxScore, ...$signatures);
    }
}
