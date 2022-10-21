<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event;

use DateTimeImmutable;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    public readonly Uuid $eventId;
    public readonly EventName $eventName;
    public readonly DateTimeImmutable $occurredOn;

    public function __construct()
    {
        $this->eventId = Uuid::v4();
        $this->eventName = static::eventName();
        $this->occurredOn = new DateTimeImmutable();
    }

    public static function eventName(): EventName
    {
        return new EventName(
            static::context(),
            static::module(),
            static::resource(),
            static::action(),
            static::version()
        );
    }

    abstract protected static function context(): string;

    abstract protected static function module(): string;

    abstract protected static function resource(): string;

    abstract protected static function action(): string;

    private static function version(): string
    {
        return 'v1';
    }

}
