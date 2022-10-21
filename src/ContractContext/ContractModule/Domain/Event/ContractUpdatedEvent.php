<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Domain\Event;

class ContractUpdatedEvent extends ContractEvent
{
    protected static function action(): string
    {
        return 'updated';
    }

}
