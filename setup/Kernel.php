<?php declare(strict_types = 1);

namespace BloggiSetup;

use App\Configurator;

class Kernel {

    public static function boot(): Configurator
    {
        $configurator = new Configurator(appDir: __DIR__ . "/../app");
    
        $configurator->setEnvDebugMode();

        $configurator->enableTracy($configurator->getRootDir() . '/log');
        $configurator->setTimeZone('Europe/Prague');
        $configurator->setTempDirectory($configurator->getRootDir() . '/temp');
    
        $configurator->createRobotLoader()
          ->addDirectory(__DIR__)
          ->register();    

        $configurator->loadConfigs(["setup"]);

        return $configurator;
    }
}