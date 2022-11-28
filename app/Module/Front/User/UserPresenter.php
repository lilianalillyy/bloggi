<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Module\Front\User;

use App\Exception\UnexpectedValueException;
use App\Model\User\Form\PasswordFormFactory;
use App\Model\User\UserFacade;
use App\Module\Front\BaseFrontPresenter;
use Nette\Application\UI\Form;

/**
 * The user-managing presenter.
 */
class UserPresenter extends BaseFrontPresenter
{

  public function __construct(
    private readonly PasswordFormFactory $passwordFormFactory,
    private readonly UserFacade $userFacade,
  )
  {
    parent::__construct();
  }

  public function createComponentPasswordForm(): Form
  {
    $form = $this->passwordFormFactory->create();

    $form->onSuccess[] = function (Form $form) {
      $values = $form->getValues();

      $oldPassword = $values["oldPassword"];
      $newPassword = $values["newPassword"];

      // Check whether the new passwords match.
      if ($newPassword !== $values["newPasswordRepeat"]) {
        $this->flashMessage('Nové heslo se neshoduje.', 'danger');
        return;
      }

      try {
        $this->userFacade->updatePassword($this->getUserIdentity()->getUser(), $oldPassword, $newPassword);
        $this->flashMessage('Heslo změněno.');
      } catch (UnexpectedValueException $exception) {
        $this->flashMessage($exception->getMessage(), 'danger');
      }
    };

    return $form;
  }

}
