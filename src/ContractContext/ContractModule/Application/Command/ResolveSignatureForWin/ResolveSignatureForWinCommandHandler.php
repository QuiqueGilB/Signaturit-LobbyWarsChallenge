<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveSignatureForWin;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractHasNotWinnerException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Exception\ContractNotFoundException;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Service\ResolveNeedSignatureToWinService;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;

class ResolveSignatureForWinCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ContractRepository $contractRepository,
        private readonly ResolveNeedSignatureToWinService $needSignatureToWinService
    ) {
    }

    public function __invoke(ResolveSignatureForWinCommand $command): void
    {
        $contract = $this->contractRepository->byId($command->contractId)
            ?? throw ContractNotFoundException::byId($command->contractId);
        $winner = $contract->winner()
            ?? throw ContractHasNotWinnerException::unresolved($contract->id());

        $participants = array_map(function (Participant $participant) use ($winner): Participant {
            if (!$participant->hasUnknownSignature()) {
                return $participant;
            }

            $signToWin = $this->needSignatureToWinService->needToWin($winner->score(), ...$participant->signatures());
            $participant->patch(signaturesToWin: $signToWin);
            return $participant;
        }, $contract->participants());

        $contract->patch(participants: $participants);
        $this->contractRepository->save($contract);
    }
}
