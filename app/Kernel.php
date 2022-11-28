<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App;

use Contributte\Bootstrap\ExtraConfigurator;

/**
 * The kernel of the CMS.
 */
class Kernel
{

  /**
   * This array includes all configuration files that will be loaded.
   * These configuration files are in the /config directory.
   *
   * @var string[]
   */
  protected static array $configs = [
    "local",
    "common",
    "services",
    "extensions"
  ];

  public static function boot(): ExtraConfigurator
  {
    $configurator = new ExtraConfigurator();

    $appDir = __DIR__;
    $rootDir = realpath($appDir . "/..");
    $wwwDir = realpath($rootDir . "/www");

    $configurator->addParameters([
      "appDir" => $appDir,
      "rootDir" => $rootDir,
      "wwwDir" => $wwwDir
    ]);

    /**
     * This sets the environment mode based on the NETTE_DEBUG environment.
     * Setting the value to '1' or 'true' will enable the debug mode.
     */
    $configurator->setEnvDebugMode();

    $configurator->enableTracy($rootDir . '/log');
    $configurator->setTimeZone('Europe/Prague');
    $configurator->setTempDirectory($rootDir . '/temp');

    $configurator->createRobotLoader()
      ->addDirectory(__DIR__)
      ->register();

    /**
     * Load configuration files.
     */
    foreach (self::$configs as $config) {
      $configurator->addConfig($rootDir . "/config/$config.neon");
    }

    return $configurator;
  }
}
