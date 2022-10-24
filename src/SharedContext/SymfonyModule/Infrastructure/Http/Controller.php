<?php

namespace Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Http;

use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\CommandBus;
use Signaturit\LobbyWarsChallenge\SharedContext\CqrsModule\Domain\Contract\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends AbstractController
{
    public function __construct(protected readonly CommandBus $commandBus, protected readonly QueryBus $queryBus)
    {
    }

    abstract public function __invoke(Request $request): Response;
}
