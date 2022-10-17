<?php

use Symfony\Component\Dotenv\Dotenv;

$projectDir = dirname(__DIR__ . '/../../../../../..');
if (!is_file($projectDir . '/vendor/autoload_runtime.php')) {
    throw new LogicException('Symfony Runtime is missing. Try running "composer require symfony/runtime".');
}

require_once $projectDir . '/vendor/autoload_runtime.php';
(new Dotenv())->bootEnv($projectDir . '/.env');
