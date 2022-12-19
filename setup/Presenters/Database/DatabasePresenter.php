<?php declare(strict_types=1);

namespace BloggiSetup\Presenters\Database;

use BloggiSetup\Model\Database\ConnectionFactory;
use BloggiSetup\Model\Database\DatabaseConfig;
use BloggiSetup\Model\Database\DatabaseConfigForm;
use BloggiSetup\Model\Database\DatabaseConfigManager;
use BloggiSetup\Model\Database\MigrationForm;
use BloggiSetup\Model\Database\MigrationManagerFactory;
use BloggiSetup\Presenters\BaseSetupPresenter;
use Exception;
use Nette\Application\UI\Form;
use RuntimeException;

class DatabasePresenter extends BaseSetupPresenter {

  public function __construct(
    private DatabaseConfigManager $databaseConfigManager,
    private DatabaseConfigForm $databaseConfigForm,
    private ConnectionFactory $connectionFactory,
    private MigrationManagerFactory $migrationManagerFactory,
    private MigrationForm $migrationForm,
  )
  {}

  public function createComponentDatabaseConfigForm(): Form
  {
    $form = $this->databaseConfigForm->create();

    $form->onSuccess[] = function (Form $form, DatabaseConfig $data) {
      try {
        $this->databaseConfigManager->setup($data);
        $this->redirect(":migrate");
      } catch (RuntimeException $e) {
        $this->flashMessage($e->getMessage(), 'danger');
      }
    };

    return $form;
  }

  public function createComponentMigrationForm(): Form
  {
    $form = $this->migrationForm->create();

    $form->onSuccess[] = function () {
      try {
        $connection = $this->connectionFactory->createFromConfig();
        $migrationManager = $this->migrationManagerFactory->create($connection);

        $version = $migrationManager->resolveVersionAlias('latest');     
        $migrationManager->migrate($version, $migrationManager->getMigratorConfiguration());
      } catch (Exception $e) {
        $this->flashMessage($e->getMessage(), 'danger');
      }
    };

    return $form;
  }

}
