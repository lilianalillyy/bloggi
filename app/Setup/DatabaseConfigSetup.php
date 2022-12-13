<?php declare(strict_types=1);

namespace App\Setup;

use App\Config\Configurator;
use App\Setup\DatabaseConfig;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use RuntimeException;

class DatabaseConfigSetup
{

  public function __construct(
    private Configurator $configurator,
    private Configuration $dbalConfiguration
  )
  {
  }

  private function createConfigArray(DatabaseConfig $config)
  {
    return [
      "parameters" => [
        "database" => [
          "host" => $config->host,
          "port" => $config->port,
          "dbname" => $config->databaseName,
          "user" => $config->user,
          "password" => $config->password,
          "driver" => $config->driver
        ]
      ]
    ];
  }

  public function writeDatabaseConfig(DatabaseConfig $config)
  {
    $this->configurator->write("local", $this->createConfigArray($config));
  }

  public function attemptConnection(DatabaseConfig $config)
  {
    $connection = DriverManager::getConnection($this->createConfigArray($config)["parameters"]["database"], $this->dbalConfiguration);
    $connection->connect();

    return $connection->isConnected();
  }

  public function setup(DatabaseConfig $config): void
  {
    if (!$this->attemptConnection($config)) {
      throw new RuntimeException();
    }

    $this->writeDatabaseConfig($config);
  }

}
