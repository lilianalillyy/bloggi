<?php declare(strict_types=1);

namespace App\Model\User;

use App\Model\Database\Traits\TimestampableTrait;
use App\Model\Database\Traits\UuidTrait;
use App\Utils\Arrays\ArrayExpressible;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User extends ArrayExpressible
{
  use UuidTrait;
  use TimestampableTrait;

  #[ORM\Column(name: 'username', type: 'string', length: 32, unique: true)]
  private string $username;

  #[ORM\Column(length: 255, unique: true)]
  #[Gedmo\Slug(fields: ['username'])]
  private string $slug;

  #[ORM\Column(name: 'email', type: 'string', unique: true)]
  private string $email;

  #[ORM\Column(name: 'password', type: 'string')]
  private string $passwordHash;

  /**
   * @var string[]
   */
  #[ORM\Column(name: 'roles', type: 'json')]
  private array $roles = [UserRole::User];

  public function __toString(): string
  {
    return $this->getEmail();
  }

  /**
   * @return string
   */
  public function getUsername(): string
  {
    return $this->username;
  }

  /**
   * @param string $username
   * @return User
   */
  public function setUsername(string $username): self
  {
    $this->username = $username;
    return $this;
  }

  /**
   * @return string
   */
  public function getSlug(): string
  {
    return $this->slug;
  }

  /**
   * @param string $slug
   */
  public function setSlug(string $slug): void
  {
    $this->slug = $slug;
  }

  /**
   * @return string
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * @param string $email
   * @return User
   */
  public function setEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }

  /**
   * @return string
   */
  public function getPasswordHash(): string
  {
    return $this->passwordHash;
  }

  /**
   * @param string $passwordHash
   * @return User
   */
  public function setPasswordHash(string $passwordHash): self
  {
    $this->passwordHash = $passwordHash;
    return $this;
  }

  /**
   * @return array
   */
  public function getRoles(): array
  {
    return $this->roles;
  }

  /**
   * @param string[] $roles
   */
  public function setRoles(array $roles): void
  {
    $this->roles = $roles;
  }

}
