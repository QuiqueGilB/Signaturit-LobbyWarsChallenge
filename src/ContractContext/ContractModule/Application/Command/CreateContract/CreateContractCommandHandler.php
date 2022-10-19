<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;

class CreateContractCommandHandler implements CommandHandler
{
    public function __construct(private readonly ContractRepository $contractRepository)
    {
    }

    public function __invoke(CreateContractCommand $command): void
    {
        $contract = new Contract($command->contractId, ...$command->participants);
        $this->contractRepository->save($contract);
    }
}
