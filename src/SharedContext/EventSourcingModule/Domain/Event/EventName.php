<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Event;

use Signaturit\LobbyWarsChallenge\SharedContext\EventSourcingModule\Domain\Exception\InvalidEventNameException;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\ValueObject;

class EventName extends ValueObject
{
    public function __construct(
        private readonly string $context,
        private readonly string $module,
        private readonly string $resource,
        private readonly string $action,
        private readonly string $version = 'v1'
    ) {
        parent::__construct();
    }

    public function fqn(): string
    {
        return sprintf('signaturit.lobbyWarsChallenge.%s.%s.%s.%s.%s',
            $this->context,
            $this->module,
            $this->version,
            $this->resource,
            $this->action,
        );
    }

    public function validate(): void
    {
        str_ends_with('Context', $this->context) || throw InvalidEventNameException::byContext($this->context);
        str_ends_with('Module', $this->module) || throw InvalidEventNameException::byModule($this->module);
        preg_match('/^v\d+$/', $this->version) || throw InvalidEventNameException::byVersion($this->context);
    }

    public function __toString(): string
    {
        return $this->fqn();
    }
}
