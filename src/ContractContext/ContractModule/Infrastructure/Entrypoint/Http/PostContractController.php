<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract\CreateContractCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract\FindContractQuery;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract\FindContractQueryResponse;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostContractController extends Controller
{
    #[Route('jeje', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $contractId = Uuid::v4();

        $command = new CreateContractCommand(
            $contractId,
            new ParticipantData(Uuid::v4(), [Signature::King]),
            new ParticipantData(Uuid::v4(), [Signature::Notary])
        );
        $this->commandBus->handle($command);

        /** @var FindContractQueryResponse $queryResponse */
        $queryResponse = $this->queryBus->ask(new FindContractQuery($contractId));
        return new JsonResponse($queryResponse->data->winner, 201);
    }

}
