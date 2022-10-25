<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;

interface CommandBus
{
    public function handle(Command $command): void;
}
