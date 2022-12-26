<?php declare(strict_types = 1);

namespace BloggiSetup\Presenters\User;

use App\Model\Auth\Form\Data\RegisterFormData;
use App\Model\Auth\Form\RegisterFormFactory;
use App\Model\Database\EntityManager;
use App\Model\User\Auth\UserIdentity;
use BloggiSetup\Exception\SetupException;
use BloggiSetup\Model\User\UserManager;
use BloggiSetup\Presenters\BaseSetupPresenter;
use Nette\Application\UI\Form;

class UserPresenter extends BaseSetupPresenter
{

    public function __construct(
        private RegisterFormFactory $registerFormFactory,
        private UserManager $userManager
    ) {
    }

    public function createComponentRegisterForm(): Form
    {
      $form = $this->registerFormFactory->create();
  
      $form->onSuccess[] = function (Form $_, RegisterFormData $data) {
        try {
          $user = $this->userManager->setup($data);
          $this->user->login(new UserIdentity($user));
        } catch (SetupException $e) {
          $this->flashMessage($e->getMessage(), "danger");
        }

        $this->nextStep();
      };
  
      return $form;
    }
}