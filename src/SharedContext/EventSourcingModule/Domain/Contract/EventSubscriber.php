<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;

/** @method void __invoke(DomainEvent $domainEvent) */
interface EventSubscriber
{
    /** @return string[] */
    public static function subscribeTo(): array;

    public static function priority(): int;
}
