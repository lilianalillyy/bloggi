<?php declare(strict_types=1);

namespace BloggiSetup\Model\Database;

class DatabaseConfig {

  public function __construct(
    public string $host,
    public int $port,
    public string $databaseName,
    public string $user,
    public string $password,
    public string $driver
  ) {
  }

}
