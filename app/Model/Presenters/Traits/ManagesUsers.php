<?php declare(strict_types = 1);

namespace App\Model\Presenters\Traits;

use App\Model\User\Auth\UserIdentity;
use App\Model\User\User;
use Nette\Application\IResponse;

trait ManagesUsers {

  public function getUserIdentity(): ?UserIdentity
  {
    $identity = $this->getUser()->getIdentity();

    if (!$identity) {
      return null;
    }

    assert($identity instanceof UserIdentity);

    return $identity;
  }

  public function getLoggedUser(): ?User
  {
    $identity = $this->getUserIdentity();

    return $identity?->getUser();

  }

  public function getLoggedUserOrFail(): User
  {
    $user = $this->getLoggedUser();

    if (!$user) {
      $this->error(httpCode: IResponse::S401_UNAUTHORIZED);
    }

    return $user;
  }

}
