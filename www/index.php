<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use BloggiSetup\SetupLock;
use BloggiSetup\Kernel as SetupKernel;
use App\Kernel as AppKernel;

$kernel = AppKernel::class;

bdump($_SERVER["REQUEST_URI"]);

if (str_starts_with($_SERVER["REQUEST_URI"], "/setup")) {
    if (SetupLock::exists()) {
        die("You cannot use setup mode while the lockfile exists.");
    }
    $kernel = SetupKernel::class;
}

$configurator = $kernel::boot();
$container = $configurator->createContainer();
$application = $container->getByType(Nette\Application\Application::class);
$application->run();
