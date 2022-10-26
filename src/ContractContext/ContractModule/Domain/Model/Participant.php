<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model\Aggregate;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class Participant extends Aggregate
{
    /** @var Signature[] */
    private array $signatures;

    /** @var Signature[] */
    private array $signaturesToWin;

    private ?int $score;

    public function __construct(Uuid $id, Signature ...$signatures)
    {
        parent::__construct($id);
        $this->doUpdate(null, [], $signatures);
    }

    public function hasUnknownSignature(): bool
    {
        return in_array(Signature::Unknown, $this->signatures, true);
    }

    public function signatures(): array
    {
        return $this->signatures;
    }

    public function score(): ?int
    {
        return $this->score;
    }

    public function signaturesToWin(): array
    {
        return $this->signaturesToWin;
    }

    /**
     * @param Signature[] $signatureToWin
     * @param Signature[] $signatures
     */
    public function put(?int $score, array $signatureToWin, array $signatures): void
    {
        $this->doUpdate($score, $signatureToWin, $signatures);
    }

    /**
     * @param Signature[]|null $signaturesToWin
     * @param Signature[]|null $signatures
     */
    public function patch(int $score = null, array $signaturesToWin = null, array $signatures = null): void
    {
        $this->put(
            $score ?? $this->score,
            $signaturesToWin ?? $this->signaturesToWin ?? [],
            $signatures ?? $this->signatures ?? []
        );
    }

    /**
     * @param Signature[] $signatureToWin
     * @param Signature[] $signatures
     */
    public function doUpdate(?int $score, array $signatureToWin, array $signatures): void
    {
        $this->signatures = $signatures;
        $this->signaturesToWin = $signatureToWin;
        $this->score = $score;
    }
}
