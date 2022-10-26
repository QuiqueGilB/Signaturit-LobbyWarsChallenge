<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Infrastructure\Subscriber;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandBus;
use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Contract\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class SfSyncEventSubscriber implements EventSubscriberInterface, EventSubscriber
{
    public function __construct(protected readonly CommandBus $commandBus)
    {
    }

    final public static function getSubscribedEvents(): iterable
    {
        foreach (static::subscribeTo() as $eventName) {
            yield $eventName => ['__invoke', self::priority()];
        }
    }

    public static function priority(): int
    {
        return 0;
    }
}
