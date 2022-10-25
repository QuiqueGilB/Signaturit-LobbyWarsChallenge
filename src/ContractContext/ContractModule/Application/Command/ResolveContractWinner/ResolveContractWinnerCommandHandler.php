<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\CanNotResolveContractWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractAlreadyHasWinnerException;
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
        $contract = $this->contractRepository->byId($command->contractId)
            ?? throw ContractNotFoundException::byId($command->contractId);

        if ($contract->hasWinner()) {
            throw ContractAlreadyHasWinnerException::hasAlready($contract->id());
        }

        empty($contract->participants()) && throw CanNotResolveContractWinnerException::zero($contract->id());

        foreach ($contract->participants() as $participant) {
            $participant->patch(score: $this->resolveSignatureScoresService->acumulate(...$participant->signatures()));
        }

        $winners = $this->winners($contract->participants());
        1 !== count($winners) && throw CanNotResolveContractWinnerException::many($contract->id());

        $contract->patch(winner: $winners[0]);
        $this->contractRepository->save($contract);
    }

    /** @return Participant[] */
    private function winners(array $participants): array
    {
        $maxScore = max(array_map(static fn(Participant $participant): int => $participant->score(), $participants));
        return array_values(array_filter(
            $participants,
            static fn($participant): bool => $participant->score() === $maxScore
        ));
    }
}
