<?php declare(strict_types=1);

namespace BloggiSetup\Model\Database;

use App\Config\Writer;
use Doctrine\DBAL\DriverManager;
use Exception;
use RuntimeException;

class DatabaseConfigManager
{

  public function __construct(
    private Writer $writer,
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
    $this->writer->write("local", $this->createConfigArray($config));
  }

  public function attemptConnection(DatabaseConfig $config)
  {
    try {
      $connection = DriverManager::getConnection($this->createConfigArray($config)["parameters"]["database"]);
      $connection->connect();

    return $connection->isConnected();
    } catch (Exception $e) {
      throw new RuntimeException($e->getMessage());
    }
  }

  public function setup(DatabaseConfig $config): void
  {
    if (!$this->attemptConnection($config)) {
      throw new RuntimeException();
    }

    $this->writeDatabaseConfig($config);
  }

}
