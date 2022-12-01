<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\User\Auth;

use App\Exception\AuthenticationException;
use App\Model\Security\Passwords;
use App\Model\User\UserFacade;
use Nette\Security\Authenticator;
use Nette\Security\IdentityHandler;
use Nette\Security\IIdentity;

/**
 * The authenticator for the User entity.
 */
class UserAuthenticator implements Authenticator, IdentityHandler
{

  public function __construct(
    private readonly UserFacade $userFacade,
    private readonly Passwords $passwords
  )
  {
  }

  public function authenticate(string $user, string $password): IIdentity
  {
    $entity = $this->userFacade->findOneBy(["username" => $user]);

    // First checks if a result was found, then whether the entered password matches the saved hash.
    if (!$entity || !$this->passwords->verify($password, $entity->getPasswordHash())) {
      throw new AuthenticationException("Uživatelské jméno nebo heslo je nesprávné.");
    }

    return new UserIdentity($entity);
  }

  public function sleepIdentity(IIdentity $identity): IIdentity
  {
    return $identity;
  }

  /**
   * @param UserIdentity $identity
   * @return IIdentity|null
   */
  public function wakeupIdentity(IIdentity $identity): ?IIdentity
  {
    $user = $this->userFacade->find($identity->getId());

    return $user ? new UserIdentity($user) : null;
  }

}
