<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryMetadata;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryResponse;

/** @property FindContractQueryResponseData $data */
class FindContractQueryResponse extends QueryResponse
{
    public function __construct(FindContractQueryResponseData $data)
    {
        parent::__construct($data, new QueryMetadata(1, 1, 0, 0));
    }
}
