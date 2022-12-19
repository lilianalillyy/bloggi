<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App;

/**
 * The kernel of the CMS.
 */
class Kernel
{

  /**
   * This array includes all configuration files that will be loaded.
   * These configuration files are in the /config directory.
   *
   * @var <(BootMode|string)|string[]>[]
   */
  protected static array $configs = [
    "common" => [
      "local",
      "config",
    ],
    "cli" => [
      "cli/extensions",
      "cli/services",
    ],
    "web" => [
      "web/extensions",
      "web/services",
    ]
  ];

  public static function boot(BootMode $bootMode = BootMode::Web): Configurator
  {
    $configurator = new Configurator();

    /**
     * This sets the environment mode based on the NETTE_DEBUG environment.
     * Setting the value to '1' or 'true' will enable the debug mode.
     */
    $configurator->setEnvDebugMode();

    $configurator->enableTracy($configurator->getRootDir() . '/log');
    $configurator->setTimeZone('Europe/Prague');
    $configurator->setTempDirectory($configurator->getRootDir() . '/temp');

    $configurator->createRobotLoader()
      ->addDirectory(__DIR__)
      ->register();

    $configurator->loadConfigs(self::getConfigsForBootMode("common"));
    $configurator->loadConfigs(self::getConfigsForBootMode($bootMode));

    return $configurator;
  }

  private static function getConfigsForBootMode(BootMode|string $bootMode): array
  {
    return self::$configs[is_string($bootMode) ? $bootMode : $bootMode->value] ?? [];
  }
}
