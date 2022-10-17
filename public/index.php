<?php

use Signaturit\LobbyWarsChallenge\SharedContext\SymfonyModule\Infrastructure\Boot\Kernel;

require_once dirname(__DIR__) . '/src/SharedContext/SymfonyModule/Infrastructure/Boot/bootstrap.php';

return static fn(array $context) => new Kernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
