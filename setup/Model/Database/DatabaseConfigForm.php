<?php declare(strict_types=1);

namespace BloggiSetup\Model\Database;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;

class DatabaseConfigForm
{

  public function create(): Form
  {
    $form = new BootstrapForm;

    BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);

    $form->setRenderMode(RenderMode::VERTICAL_MODE);
    $form->getElementPrototype()->setAttribute("class", "form-signin w-100 m-auto");

    $form->addText('host', 'Host')
      ->setRequired()
      ->addRule([DatabaseConfigForm::class, 'validateHost'], 'Nebyla zadána platná adresa.');

    $form->addText('port', 'Port')
      ->setRequired()
      ->addRule($form::INTEGER, 'Nebyl zadán platný port.');

    $form->addText('databaseName', 'Jméno databáze')
      ->setRequired();

    $form->addText('user', 'Uživatel')
      ->setRequired();

    $form->addPassword('password', 'Heslo')
      ->setDefaultValue(null);

    $form->addSelect('driver', 'Driver', [
      'pdo_mysql' => 'MySQL (PDO)',
      'mysqli' => 'MySQL (mysqli)'
    ]);

    $form->addSubmit('submit', 'Submit');

    return $form;
  }

  public static function validateHost(BaseControl $input): bool
  {
    $host = $input->getValue();
    return checkdnsrr($host, "ANY") || !!filter_var($host, FILTER_VALIDATE_IP);
  }

}
