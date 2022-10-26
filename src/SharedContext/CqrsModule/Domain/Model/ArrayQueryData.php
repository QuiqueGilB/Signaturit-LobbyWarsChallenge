<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model;

use ArrayObject;

class ArrayQueryData extends ArrayObject implements QueryData
{
    public function __construct(array $array)
    {
        parent::__construct($array, 0, 'ArrayIterator');
    }
}
