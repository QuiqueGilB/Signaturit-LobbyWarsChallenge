<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event;

class ContractCreatedEvent extends ContractEvent
{
    protected static function action(): string
    {
        return 'created';
    }
}
