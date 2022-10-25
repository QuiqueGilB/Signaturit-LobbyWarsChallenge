<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\HttpModule\Infrastructure\Listener;

use Signaturit\LobbyWarsChallenge\SharedContext\SharedModule\Domain\Exception\DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class SfMakeResponseOnExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $response = match (true) {
            $throwable instanceof MethodNotAllowedHttpException => new Response('', 405),
            $throwable instanceof DomainException => $this->domainErrorToResponse($throwable),
            default => $event->getResponse()
        };

        if (null !== $response) {
            $event->setResponse($response);
        }
    }

    private function domainErrorToResponse(DomainException $domainException): Response
    {
        return new JsonResponse([
            'code' => $domainException->domainErrorCode(),
            'message' => $domainException->getMessage()
        ], 422);
    }
}
