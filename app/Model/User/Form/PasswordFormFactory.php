<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\User\Form;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;

/**
 * The form for changing the password.
 */
class PasswordFormFactory
{

  public function create(): Form
  {
    $form = new BootstrapForm();

    BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);

    $form->setAjax();

    $form->renderMode = RenderMode::SIDE_BY_SIDE_MODE;

    $form->addPassword('oldPassword', 'Staré heslo')->setRequired();

    $form->addPassword('newPassword', 'Nové heslo')->setRequired();

    $form->addPassword('newPasswordRepeat', 'Nové heslo znovu')->setRequired();

    $form->addSubmit('submit', "Změnit heslo");

    return $form;
  }

}
