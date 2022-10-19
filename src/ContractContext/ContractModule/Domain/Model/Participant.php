<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Model\Aggregate;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class Participant extends Aggregate
{
    /** @var Signature[] */
    private array $signatures;
    private ?int $score;

    public function __construct(Uuid $id, Signature ...$signatures)
    {
        parent::__construct($id);
        $this->doUpdate(null, ...$signatures);
    }

    public function update(?int $score, Signature ...$signatures): void
    {
        $this->doUpdate($score, ...$signatures);
    }

    public function signatures(): array
    {
        return $this->signatures;
    }

    public function score(): ?int
    {
        return $this->score;
    }

    protected function doUpdate(?int $score, Signature ...$signatures): void
    {
        $this->signatures = $signatures;
        $this->score = $score;
    }
}
