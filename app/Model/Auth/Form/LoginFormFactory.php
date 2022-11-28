<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\Auth\Form;

use Nette\Application\UI\Form;

/**
 * The authentication form.
 */
class LoginFormFactory
{

  public function create(): Form
  {
    $form = new Form();

    $form->addText('username', 'Uživatelské jméno')
      ->setMaxLength(32)
      ->setRequired();

    $form->addPassword('password', 'Heslo')
      ->setRequired();

    $form->addSubmit('submit', 'Přihlásit se');

    return $form;
  }

}
