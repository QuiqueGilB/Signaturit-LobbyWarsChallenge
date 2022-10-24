<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\CreateContract;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Contract\ContractRepository;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Contract;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Model\Participant;
use Signaturit\LobbyWarsChallenge\ContractContext\SharedModule\Domain\Data\ParticipantData;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandHandler;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class CreateContractCommandHandler implements CommandHandler
{
    public function __construct(private readonly ContractRepository $contractRepository)
    {
    }

    public function __invoke(CreateContractCommand $command): void
    {
        $participants = array_map(static function (ParticipantData $data): Participant {
            return new Participant($data->participantId ?? Uuid::v4(), ...$data->signatures);
        }, $command->participants);

        $contract = new Contract($command->contractId, ...$participants);
        $this->contractRepository->save($contract);
    }
}
