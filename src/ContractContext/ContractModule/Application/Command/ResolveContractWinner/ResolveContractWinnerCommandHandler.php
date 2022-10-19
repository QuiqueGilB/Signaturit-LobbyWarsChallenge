<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractHasNotWinnersException;
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
        null === $contract && throw ContractNotFoundException::byId($command->contractId);

        $participants = $contract->participants;

        foreach ($participants as $participant) {
            $participant->update($this->resolveSignatureScoresService->acumulate(...$participant->signatures()));
        }

        $maxScore = max(array_map(static fn(Participant $participant) => $participant->score(), $participants));
        /** @var Participant[] $winners */
        $winners = array_filter($participants, static fn($participant) => $participant->score() === $maxScore);

        empty($winners) && throw ContractHasNotWinnersException::zero($contract->id());
        1 !== count($winners) && throw ContractHasNotWinnersException::many($contract->id());

        $contract->update($winners[0]);
        $this->contractRepository->save($contract);
    }
}
