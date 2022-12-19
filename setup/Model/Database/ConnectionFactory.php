<?php declare(strict_types = 1);

namespace BloggiSetup\Model\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ConnectionFactory {

    public function __construct(private array $params) {

    }

    public function createFromConfig(): Connection
    {
        return $this->create($this->params);
    }

    public function create(array $config): Connection {
        return DriverManager::getConnection($config);
    }

}