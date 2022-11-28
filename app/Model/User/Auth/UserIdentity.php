<?php declare(strict_types=1);

namespace App\Model\User\Auth;

use App\Model\User\User;
use Nette\Security\IIdentity;

/**
 * This is an extended identity.
 */
class UserIdentity implements IIdentity
{
  /** @var string[] */
  private array $roles;

  public function __construct(private readonly User $user)
  {
    // TODO
    $this->roles = [];
  }

  // TODO: change mixed
  public function getId(): string
  {
    return $this->user->getId();
  }

  /**
   * @return string[]
   */
  public function getRoles(): array
  {
    return $this->roles;
  }

  /**
   * @return User
   */
  public function getUser(): User
  {
    return $this->user;
  }

  /**
   * @return array<string, mixed>
   */
  public function getData(): array
  {
    return [
      "id" => $this->getId(),
      "user" => $this->user->toArray(),
      "roles" => $this->getRoles(),
    ];
  }
}
