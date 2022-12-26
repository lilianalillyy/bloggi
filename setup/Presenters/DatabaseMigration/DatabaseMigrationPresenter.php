<?php declare(strict_types = 1);

namespace BloggiSetup\Presenters\DatabaseMigration;

use BloggiSetup\Exception\SetupException;
use BloggiSetup\Model\Database\DatabaseMigrationForm;
use BloggiSetup\Model\Database\DatabaseMigrationManager;
use BloggiSetup\Presenters\BaseSetupPresenter;
use Nette\Application\UI\Form;

class DatabaseMigrationPresenter extends BaseSetupPresenter
{

    public function __construct(
      private DatabaseMigrationForm $databaseMigrationForm,
      private DatabaseMigrationManager $databaseMigrationManager
    ) {
    }

    public function createComponentDatabaseMigrationForm(): Form
    {
      $form = $this->databaseMigrationForm->create();

      $form->onSuccess[] = function () {
        try {
          $this->databaseMigrationManager->setup();
        } catch (SetupException $e) {
          $this->flashMessage($e->getMessage(), 'danger');
          return;
        }

        $this->nextStep();
      };
  
      return $form;
    }

}