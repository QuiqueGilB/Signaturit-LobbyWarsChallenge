<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract\CreateContractCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract\FindContractQuery;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract\FindContractQueryResponse;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PostContractController extends Controller
{
    #[Route('jeje', methods: ['GET', 'POST'])]
    public function __invoke()
    {
        $contractId = Uuid::v4();

        $command = new CreateContractCommand(
            $contractId,
            new Participant(Uuid::v4(), 'KV'),
            new Participant(Uuid::v4(), 'KV')
        );
        $this->commandBus->handle($command);

        /** @var FindContractQueryResponse $queryResponse */
        $queryResponse = $this->queryBus->ask(new FindContractQuery($contractId));
        return new JsonResponse($queryResponse->data->winner, 201);
    }

}
