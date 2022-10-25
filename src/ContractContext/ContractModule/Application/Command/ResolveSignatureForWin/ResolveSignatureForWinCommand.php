<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Application\Command\ResolveSignatureForWin;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Model\Command;
use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\ValueObject\Uuid;

class ResolveSignatureForWinCommand extends Command
{
    public function __construct(public readonly Uuid $contractId)
    {
    }
}
