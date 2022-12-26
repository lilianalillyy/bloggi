<?php declare(strict_types=1);

namespace App\Module\Security\Auth;

use App\Exception\AuthenticationException;
use App\Model\Auth\Form\Data\LoginFormData;
use App\Model\Auth\Form\Data\RegisterFormData;
use App\Model\Auth\Form\LoginFormFactory;
use App\Model\Auth\Form\RegisterFormFactory;
use App\Model\User\Auth\UserIdentity;
use App\Model\User\UserFacade;
use App\Module\Security\BaseSecurityPresenter;
use Exception;
use Nette\Application\UI\Form;

class AuthPresenter extends BaseSecurityPresenter
{

  public const HOMEPAGE_REDIRECT = ":Front:Homepage:default";

  public function __construct(
    private readonly LoginFormFactory $loginFormFactory,
    private readonly RegisterFormFactory $registerFormFactory,
    private readonly UserFacade $userFacade,
  )
  {
    parent::__construct();
  }

  public function actionLogout(): void
  {
    if (!$this->getUser()->isLoggedIn()) {
      $this->flashMessage('Nejste přihlášeni.', 'warning');
      $this->redirect(self::HOMEPAGE_REDIRECT);
    }

    $this->getUser()->logout(true);
    $this->flashMessage('Úspěšně odhlášeni.', 'success');

    $this->restoreRequest($this->backlink);
    $this->redirect(self::HOMEPAGE_REDIRECT);
  }

  public function createComponentLoginForm(): Form
  {
    $form = $this->loginFormFactory->create();

    $form->onSuccess[] = function (Form $form, LoginFormData $data) {
      try {
        $this->getUser()->login($data->username, $data->password);

        $this->restoreRequest($this->backlink);
        $this->redirect(self::HOMEPAGE_REDIRECT);
      } catch (Exception $e) {
        $this->flashMessage($e->getMessage(), "danger");
      }
    };

    return $form;
  }

  public function createComponentRegisterForm(): Form
  {
    $form = $this->registerFormFactory->create();

    $form->onSuccess[] = function (Form $form, RegisterFormData $data) {
      try {
        $this->user->login(new UserIdentity($this->userFacade->create($data)));

        $this->restoreRequest($this->backlink);
        $this->redirect(self::HOMEPAGE_REDIRECT);
      } catch (Exception $e) {
        $this->flashMessage($e->getMessage(), "danger");
      }
    };

    return $form;
  }

  protected function startup()
  {
    if ($this->getUser()->isLoggedIn() && $this->getAction() !== "logout") {
      $this->flashMessage('Již jste přihlášeni.', 'warning');

      $this->restoreRequest($this->backlink);
      $this->redirect(self::HOMEPAGE_REDIRECT);
    }

    parent::startup();
  }

}
