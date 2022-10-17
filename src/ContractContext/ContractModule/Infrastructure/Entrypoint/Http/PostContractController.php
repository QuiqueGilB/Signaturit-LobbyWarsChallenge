<?php

namespace Signaturit\LobbyWarsChallenge\ContractContext\ContractModule\Infrastructure\Entrypoint\Http;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostContractController extends AbstractController
{
    #[Route('jeje')]
    public function __invoke()
    {
        return new Response('wiiiii');
    }

}
