<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\src\ContractContext\ContractModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\Stub;

/**
 * @method self withId(Uuid $id)
 * @method self withWinner(?Participant $winner)
 * @method self withParticipants(Participant[] $participant)
 */
class ContractStub extends Stub
{
    protected Uuid $id;
    protected ?Participant $winner;
    /** @var Participant[] */
    protected array $participants;

    public function reset(): void
    {
        parent::reset();
        $this->id = Uuid::v4();
        $this->winner = null;
        $this->participants = [];
    }

    public static function stubOf(): string
    {
        return Contract::class;
    }
}
