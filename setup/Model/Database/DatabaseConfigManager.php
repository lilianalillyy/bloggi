<?php declare(strict_types=1);

namespace BloggiSetup\Model\Database;

use App\Config\Writer;
use BloggiSetup\Exception\SetupException;
use Doctrine\DBAL\DriverManager;
use Exception;
use RuntimeException;

class DatabaseConfigManager
{

  public array $defaults = [
    "host" => "127.0.0.1",
    "port" => "3306",
    "dbname" => "bloggi",
    "user" => "bloggi",
    "password" => null,
    "driver" => "pdo_mysql"
  ];

  public function __construct(
    private Writer $writer,
    private array $database
  )
  {
  }

  public function getDefaults(): DatabaseConfig
  {
    $config = array_merge($this->database, $this->defaults);
    $config["port"] = intval($config["port"]);

    return DatabaseConfig::createFromParameters($config);
  }

  private function createConfigArray(DatabaseConfig $config)
  {
    return [
      "parameters" => [
        "database" => $config->toParameters()
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
      $connection = DriverManager::getConnection($config->toParameters());
      $connection->connect();

    return $connection->isConnected();
    } catch (Exception $e) {
      throw new SetupException($e->getMessage(), $e->getCode(), $e);
    }
  }

  public function setup(DatabaseConfig $config): void
  {
    if (!$this->attemptConnection($config)) {
      throw new SetupException("Connection closed.");
    }

    $this->writeDatabaseConfig($config);
  }

}
