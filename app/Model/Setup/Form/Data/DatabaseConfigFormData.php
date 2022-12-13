<?php declare(strict_types=1);

namespace App\Model\Setup\Form\Data;

use App\Setup\DatabaseConfig;

class DatabaseConfigFormData extends DatabaseConfig {

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
