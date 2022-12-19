<?php declare(strict_types = 1);

use BloggiSetup\Kernel;
use BloggiSetup\SetupLock;
use Nette\Application\Application;

require __DIR__ . '/../vendor/autoload.php';

if (SetupLock::exists()) {
    // TODO
    die("Setup lock exists.");
}

Kernel::boot()
    ->createContainer()
    ->getByType(Application::class)
    ->run();