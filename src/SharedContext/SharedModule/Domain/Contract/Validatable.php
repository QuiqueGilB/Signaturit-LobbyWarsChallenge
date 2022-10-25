<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Contract;

interface Validatable
{
    public function validate(): void;
}
