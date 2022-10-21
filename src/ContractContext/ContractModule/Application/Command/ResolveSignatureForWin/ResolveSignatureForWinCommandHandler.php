<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveSignatureForWin;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;

class ResolveSignatureForWinCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ContractRepository $contractRepository,
        private readonly ResolveSignatureScoresService $resolveSignatureScoresService
    ) {

    }

    public function __invoke(ResolveSignatureForWinCommand $command): void
    {
        $contract = $this->contractRepository->byId($command->contractId) ?? throw ContractNotFoundException::byId($command->contractId);
        $winner = $contract->winner() ?? throw ContractWinnerException::unresolved($contract->id());

        $participants = array_map(function (Participant $participant) use ($winner): Participant {
            if (!$participant->hasUnknownSignature()) {
                return $participant;
            }

            $signaturesToWin = $this->resolveSignatureScoresService->needToWin($winner->score(), ...$participant->signatures());
            $participant->patch(signaturesToWin: $signaturesToWin);
            return $participant;
        }, $contract->participants());

        $contract->patch(participants: $participants);
        $this->contractRepository->save($contract);
    }
}
