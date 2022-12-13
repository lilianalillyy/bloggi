<?php declare(strict_types=1);

namespace App\Model\Setup\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;

class DatabaseConfigFormFactory
{

  public static function create(): Form
  {
    $form = new BootstrapForm;

    BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);

    $form->addText('host', 'Host')
      ->setRequired()
      ->addRule([DatabaseConfigFormFactory::class, 'validateHost'], 'Nebyla zadána platná adresa.');

    $form->addText('port', 'Port')
      ->setRequired()
      ->addRule($form::INTEGER, 'Nebyl zadán platný port.');

    $form->addText('databaseName', 'Jméno databáze')
      ->setRequired();

    $form->addText('user', 'Uživatel')
      ->setRequired();

    $form->addPassword('password', 'Heslo')
      ->setRequired();

    $form->addSelect('driver', 'Driver', [
      'pdo_mysql' => 'MySQL (PDO)',
      'mysqli' => 'MySQL (mysqli)'
    ])->setDefaultValue('pdo_mysql');

    $form->addSubmit('submit', 'Submit');

    return $form;
  }

  public static function validateHost(BaseControl $input): bool
  {
    $host = $input->getValue();
    return checkdnsrr($host, "ANY") || !!filter_var($host, FILTER_VALIDATE_IP);
  }

}
