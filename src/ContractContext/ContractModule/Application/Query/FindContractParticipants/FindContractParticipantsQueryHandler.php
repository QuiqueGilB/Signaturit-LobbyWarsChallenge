<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContractParticipants;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\QueryHandler;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\QueryMetadata;

class FindContractParticipantsQueryHandler implements QueryHandler
{
    public function __construct(private readonly ContractRepository $contractRepository)
    {
    }

    public function __invoke(FindContractParticipantsQuery $query): FindContractParticipantsQueryResponse
    {
        $contract = $this->contractRepository->byId($query->contractId)
            ?? throw ContractNotFoundException::byId($query->contractId);

        return new FindContractParticipantsQueryResponse(
            new FindContractParticipantsQueryResponseData($contract->participants()),
            new QueryMetadata($results = count($contract->participants()), $results, 0, 0)
        );
    }

}
