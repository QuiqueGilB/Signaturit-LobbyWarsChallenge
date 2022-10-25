<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service;

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
}
