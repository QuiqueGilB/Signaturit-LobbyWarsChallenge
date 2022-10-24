<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\CanNotResolveContractWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveSignatureScoresService;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;

class ResolveContractWinnerCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ContractRepository $contractRepository,
        private readonly ResolveSignatureScoresService $resolveSignatureScoresService
    ) {
    }

    public function __invoke(ResolveContractWinnerCommand $command): void
    {
        $contract = $this->contractRepository->byId($command->contractId);
        is_null($contract) && throw ContractNotFoundException::byId($command->contractId);

        if ($contract->hasWinner()) {
            return;
        }

        $participants = $contract->participants();

        array_walk($participants, function (Participant $participant): void {
            $participant->update($this->resolveSignatureScoresService->acumulate(...$participant->signatures()));
        });

        $maxScore = max(array_map(static fn(Participant $participant): int => $participant->score(), $participants));
        $winners = array_filter($participants, static fn($participant): bool => $participant->score() === $maxScore);

        empty($winners) && throw CanNotResolveContractWinnerException::zero($contract->id());
        1 !== count($winners) && throw CanNotResolveContractWinnerException::many($contract->id());

        $contract->patch(winner: $winners[0]);
        $this->contractRepository->save($contract);
    }
}
