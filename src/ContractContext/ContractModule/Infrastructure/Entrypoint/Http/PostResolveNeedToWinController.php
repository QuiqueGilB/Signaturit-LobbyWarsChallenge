<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract\CreateContractCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContractParticipants\FindContractParticipantsQuery;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Query\FindContractParticipants\FindContractParticipantsQueryResponse;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\ValueObject\Signature;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;
use Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostResolveNeedToWinController extends Controller
{
    #[Route('contract/need-to-win', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $contractId = Uuid::v4();
        $participantsData = $this->makeParticipantsData($request);

        $command = new CreateContractCommand($contractId, ...$participantsData);
        $this->commandBus->handle($command);

        /** @var FindContractParticipantsQueryResponse $queryResponse */
        $queryResponse = $this->queryBus->ask(new FindContractParticipantsQuery($contractId));
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

    private function makeResponse(FindContractParticipantsQueryResponse $queryResponse): string
    {
        return implode(
            ', ',
            array_map(function (ParticipantData $participantData): string {
                return sprintf('%s: %s',
                    $this->signaturesToString(...$participantData->signatures),
                    $this->signaturesToString(...$participantData->needToWin));
            }, iterator_to_array($queryResponse->data))
        );
    }

    private function signaturesToString(Signature ...$signatures): string
    {
        return implode('', array_map(static fn(Signature $signature) => $signature->value, $signatures));
    }
}
