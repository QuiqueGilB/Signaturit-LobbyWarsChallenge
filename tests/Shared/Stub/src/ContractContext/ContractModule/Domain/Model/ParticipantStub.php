<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\src\ContractContext\ContractModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\Stub;

/**
 * @method self withId(Uuid $id)
 * @method self withSignatures(Signature[] $signatures)
 * @method self withSignaturesToWin(Signature[] $signatures)
 * @method self withScore(?int $score)
 */
class ParticipantStub extends Stub
{
    protected Uuid $id;

    /** @var Signature[] */
    protected array $signatures;

    /** @var Signature[] */
    protected array $signaturesToWin;

    protected ?int $score;


    public function reset(): void
    {
        parent::reset();
        $this->id = Uuid::v4();
        $this->signatures = [];
        $this->signaturesToWin = [];
        $this->score = null;
    }

    public static function stubOf(): string
    {
        return Participant::class;
    }
}
