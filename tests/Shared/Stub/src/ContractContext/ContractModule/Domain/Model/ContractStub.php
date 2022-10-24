<?php

namespace Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\src\ContractContext\ContractModule\Domain\Model;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\Tests\Shared\Stub\Stub;

/**
 * @method self withId(Uuid $id)
 * @method self withWinner(?Participant $winner)
 */
class ContractStub extends Stub
{
    protected Uuid $id;
    protected ?Participant $winner;

    public function reset(): void
    {
        parent::reset();
        $this->id = Uuid::v4();
        $this->winner = null;
    }

    public static function stubOf(): string
    {
        return Contract::class;
    }
}
