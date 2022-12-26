<?php declare(strict_types=1);

namespace BloggiSetup\Presenters\DatabaseConfig;

use BloggiSetup\Exception\SetupException;
use BloggiSetup\Model\Database\DatabaseConfig;
use BloggiSetup\Model\Database\DatabaseConfigForm;
use BloggiSetup\Model\Database\DatabaseConfigManager;
use BloggiSetup\Presenters\BaseSetupPresenter;
use Nette\Application\UI\Form;

class DatabaseConfigPresenter extends BaseSetupPresenter {

  public function __construct(
    private DatabaseConfigManager $databaseConfigManager,
    private DatabaseConfigForm $databaseConfigForm,
  )
  {}

  public function createComponentDatabaseConfigForm(): Form
  {
    $form = $this->databaseConfigForm->create();

    $form->setDefaults($this->databaseConfigManager->getDefaults());

    $form->onSuccess[] = function (Form $_, DatabaseConfig $data) {
      try {
        $this->databaseConfigManager->setup($data);
      } catch (SetupException $e) {
        $this->flashMessage($e->getMessage(), 'danger');
      }

      $this->nextStep();
    };

    return $form;
  }

}
