<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\QueryHandler;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryResponse;

class FindContractQueryHandler implements QueryHandler
{
    public function __construct(private readonly ContractRepository $contractRepository)
    {
    }

    public function __invoke(FindContractQuery $query): QueryResponse
    {
        $contract = $this->contractRepository->byId($query->contractId);
        null === $contract && throw ContractNotFoundException::byId($query->contractId);
        return new FindContractQueryResponse(new FindContractQueryResponseData($contract));
    }
}
