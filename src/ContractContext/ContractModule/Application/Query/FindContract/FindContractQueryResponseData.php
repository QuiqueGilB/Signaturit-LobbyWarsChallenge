<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryData;

class FindContractQueryResponseData implements QueryData
{
    public readonly string $contractId;
    public readonly ?ParticipantData $winner;

    public function __construct(Contract $contract)
    {
        $this->contractId = $contract->id()->value;
        $winner = $contract->winner();
        $this->winner = $winner ? new ParticipantData($winner->id(), $winner->signatures()) : null;
    }
}
