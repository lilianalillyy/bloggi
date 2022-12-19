<?php declare(strict_types = 1);

namespace BloggiSetup\Model\Database;

use App\Model\Database\MigrationManager;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;

class MigrationManagerFactory {

    public static function create(Connection $connection) {
        return new MigrationManager(
            DependencyFactory::fromConnection(
                new ExistingConfiguration(new Configuration()), 
                new ExistingConnection($connection)
            )
        );
    }

}