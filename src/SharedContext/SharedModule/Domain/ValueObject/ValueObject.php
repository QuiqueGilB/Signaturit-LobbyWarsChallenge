<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Contract\Validatable;

abstract class ValueObject implements Validatable
{
    public function __construct()
    {
        $this->validate();
    }
}
