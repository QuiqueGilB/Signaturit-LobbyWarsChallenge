<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;

interface CommandHandler
{
    public function __invoke(Command $command): void;
}
