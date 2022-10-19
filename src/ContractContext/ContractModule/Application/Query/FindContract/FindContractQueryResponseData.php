<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryData;

class FindContractQueryResponseData implements QueryData
{
    public readonly string $contractId;
    public readonly ?string $winner;
    public readonly ?string $signatureForWin;

    public function __construct(Contract $contract)
    {
        $this->contractId = $contract->id()->value;
        $this->winner = $contract->winner();
        $this->signatureForWin = $contract->signatureForWin();
    }
}
