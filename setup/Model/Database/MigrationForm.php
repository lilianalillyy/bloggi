<?php declare(strict_types=1);

namespace BloggiSetup\Model\Database;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;

class MigrationForm
{

  public static function create(): Form
  {
    $form = new BootstrapForm;

    BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);

    $form->setRenderMode(RenderMode::VERTICAL_MODE);
    $form->getElementPrototype()->setAttribute("class", "form-signin w-100 m-auto");

    $form->addSubmit('submit', 'Zahájit migraci');

    return $form;
  }

}
