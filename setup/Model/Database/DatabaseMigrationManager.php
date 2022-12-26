<?php declare(strict_types = 1);

namespace BloggiSetup\Model\Database;

use App\Model\Database\MigrationManager;
use BloggiSetup\Exception\SetupException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
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
      // TODO: deal with FKs in a different way
      $this->connection->executeStatement("SET FOREIGN_KEY_CHECKS=0");
      foreach ($this->schemaManager->listTables() as $table) {
        $this->schemaManager->dropTable($table);
      }
      $this->connection->executeStatement("SET FOREIGN_KEY_CHECKS=1");

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