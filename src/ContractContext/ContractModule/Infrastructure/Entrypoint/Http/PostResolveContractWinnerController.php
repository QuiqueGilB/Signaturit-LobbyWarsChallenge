<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract\CreateContractCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract\FindContractQuery;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContract\FindContractQueryResponse;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Http\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostResolveContractWinnerController extends Controller
{
    #[Route('contract/winner', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $contractId = Uuid::v4();
        $participantsData = $this->makeParticipantsData($request);

        $command = new CreateContractCommand($contractId, ...$participantsData);
        $this->commandBus->handle($command);

        /** @var FindContractQueryResponse $queryResponse */
        $queryResponse = $this->queryBus->ask(new FindContractQuery($contractId));
        return new Response($this->makeResponse($queryResponse), 201);
    }

    /** @return Signature[][] */
    private function strToParticipantSignatures(string $signatures): array
    {
        return array_map(static function (string $signaturesInOneParticipant) {
            return array_map(
                static fn(string $signature): Signature => Signature::from($signature),
                str_split($signaturesInOneParticipant)
            );
        }, explode(' ', $signatures));
    }

    /** @return ParticipantData[] */
    private function makeParticipantsData(Request $request): array
    {
        $participantSignatures = $this->strToParticipantSignatures($request->getContent());
        return array_map(static function ($signatures): ParticipantData {
            return new ParticipantData(Uuid::v4(), $signatures);
        }, $participantSignatures);
    }

    private function makeResponse(FindContractQueryResponse $queryResponse): string
    {
        return implode(
            '',
            array_map(
                static fn(Signature $signature) => $signature->value,
                $queryResponse->data->winner->signatures
            ));
    }
}
