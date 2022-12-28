<?php declare(strict_types = 1);

namespace BloggiSetup\Model\Database;

use App\Model\Database\MigrationManager;
use BloggiSetup\Exception\SetupException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Exception;

class DatabaseMigrationManager {

  public function __construct(
    private AbstractSchemaManager $schemaManager,
    private MigrationManager $migrationManager,
    private Connection $connection
  )
  {
  }

  public function setup()
  {
    try {
      // Clean the database before migration
      $this->schemaManager->dropSchemaObjects($this->schemaManager->introspectSchema());

      // Ensure metadata storage is at latest version
      $this->migrationManager->ensureInitializedMetadata();

      // Migrate to newest database version
      $this->migrationManager->migrate(
        $this->migrationManager->resolveVersionAlias('latest'), 
        $this->migrationManager->getMigratorConfiguration()
      );
    } catch (Exception $e) {
      throw new SetupException($e->getMessage(), $e->getCode(), $e);
    }
  }

}