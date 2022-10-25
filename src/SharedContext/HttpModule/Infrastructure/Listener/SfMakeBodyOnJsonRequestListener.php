<?php

declare(strict_types=1);

namespace Signaturit\LobbyWarsChallenge\SharedContext\HttpModule\Infrastructure\Listener;

use RuntimeException;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Throwable;

class SfMakeBodyOnJsonRequestListener
{
    public function onRequest(RequestEvent $event): void
    {
        if (false === $event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->headers->contains('Content-Type', 'application/json')) {
            try {
                $payload = json_decode($request->getContent() ?: "{}", true, 512, JSON_THROW_ON_ERROR);
                $request->request->add($payload);

            } catch (Throwable $e) {
                throw new RuntimeException("", 0, $e);
            }
        }
    }
}
