<?php declare(strict_types=1);

namespace BloggiSetup\Model\Database;

class DatabaseConfig {

  public function __construct(
    public string $host,
    public int $port,
    public string $databaseName,
    public string $user,
    public ?string $password = null,
    public string $driver
  ) {
  }

  public static function create(
    string $host,
    int $port,
    string $databaseName,
    string $user,
    ?string $password = null,
    string $driver
  ): self
  {
    return new self($host, $port, $databaseName, $user, $password, $driver);
  }

  public static function createFromParameters(array $parameters): self
  {
    return self::create(
      host: $parameters["host"],
      port: $parameters["port"],
      databaseName: $parameters["dbname"],
      user: $parameters["user"],
      password: $parameters["password"],
      driver: $parameters["driver"]
    );
  }

  public function toParameters(): array
  {
    return [
      "host" => $this->host,
      "port" => $this->port,
      "dbname" => $this->databaseName,
      "user" => $this->user,
      "password" => $this->password,
      "driver" => $this->driver
    ];
  }

}
