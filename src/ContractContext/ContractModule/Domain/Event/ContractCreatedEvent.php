<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event;

class ContractCreatedEvent extends ContractEvent
{
    protected static function action(): string
    {
        return 'created';
    }
}
