<?php declare(strict_types=1);

namespace App\Module\Setup\Database;
use App\Model\Setup\Form\Data\DatabaseConfigFormData;
use App\Model\Setup\Form\DatabaseConfigFormFactory;
use App\Module\Setup\BaseSetupPresenter;
use App\Setup\DatabaseConfigSetup;
use Exception;
use Nette\Application\UI\Form;

class DatabasePresenter extends BaseSetupPresenter {

  public function __construct(
    private DatabaseConfigSetup $databaseConfigSetup,
    private DatabaseConfigFormFactory $databaseConfigFormFactory
  )
  {}

  public function createComponentDatabaseConfigForm(): Form
  {
    $form = $this->databaseConfigFormFactory->create();

    $self = $this;
    $form->onSuccess[] = function (Form $form, DatabaseConfigFormData $data) use ($self) {
      try {
        $self->databaseConfigSetup->setup($data);
        $self->redirect(":migrate");
      } catch (Exception $e) {
        $form->addError($e->getMessage());
      }
    };

    return $form;
  }

}
