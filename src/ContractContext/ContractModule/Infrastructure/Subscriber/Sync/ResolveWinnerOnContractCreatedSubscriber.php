<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Subscriber\Sync;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveContractWinner\ResolveContractWinnerCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractCreatedEvent;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Infrastructure\Subscriber\SfSyncEventSubscriber;

class ResolveWinnerOnContractCreatedSubscriber extends SfSyncEventSubscriber
{
    public static function subscribeTo(): array
    {
        return [
            ContractCreatedEvent::eventName()->fqn()
        ];
    }

    public function __invoke(ContractCreatedEvent $domainEvent): void
    {
        $this->commandBus->handle(new ResolveContractWinnerCommand($domainEvent->contractId));
    }
}
