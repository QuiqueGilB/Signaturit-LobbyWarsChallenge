<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Service;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event\DomainEvent;

class EventCollector
{
    private static self $instance;

    /** @var DomainEvent[] */
    private array $events;

    private function __construct()
    {
        $this->events = [];
    }

    public static function instance(): self
    {
        self::$instance ??= new self();
        return self::$instance;
    }

    public function publish(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function pull(): array
    {
        $events =  $this->events;
        $this->purge();
        return $events;
    }

    public function purge(): void
    {
        $this->events = [];
    }
}
