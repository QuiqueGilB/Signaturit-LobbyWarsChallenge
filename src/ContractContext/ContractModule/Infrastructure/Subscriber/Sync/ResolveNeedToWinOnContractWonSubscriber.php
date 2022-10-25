<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Subscriber\Sync;

use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveSignatureForWin\ResolveSignatureForWinCommand;
use Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event\ContractWonEvent;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Infrastructure\Subscriber\SfSyncEventSubscriber;

class ResolveNeedToWinOnContractWonSubscriber extends SfSyncEventSubscriber
{
    public static function subscribeTo(): array
    {
        return [
            ContractWonEvent::eventName()->fqn()
        ];
    }

    public function __invoke(ContractWonEvent $domainEvent): void
    {
        $this->commandBus->handle(new ResolveSignatureForWinCommand($domainEvent->contractId));
    }
}
