<?php declare(strict_types=1);

namespace App\Module\Front;

use App\Model\User\Auth\UserIdentity;
use App\Model\User\User as LoggedUser;
use Nette\Security\User;
use Nette\Bridges\ApplicationLatte\Template;
use stdClass;

abstract class BaseFrontTemplate extends Template
{

  public ?LoggedUser $loggedUser;

  public ?UserIdentity $userIdentity;

  public BaseFrontPresenter $presenter;

  public User $user;

  /**
   * @var stdClass[]
   */
  public array $flashes;

}
