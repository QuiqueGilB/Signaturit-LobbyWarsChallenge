<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Boot;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
