<?php declare(strict_types=1);

namespace App\Model\User;

use App\Exception\UnexpectedValueException;
use App\Model\Auth\Form\Data\RegisterFormData;
use App\Model\Database\EntityManager;
use App\Model\Security\Passwords;

class UserFacade
{

  private UserRepository $repository;

  public function __construct(
    private readonly Passwords $passwords,
    public readonly EntityManager $em
  )
  {
    $this->repository = $em->user();
  }

  /**
   * @param string $id
   * @return User|null
   */
  public function find(string $id): ?User {
    return $this->repository->find($id);
  }

  /**
   * @param array<string, mixed> $criteria
   * @param array<string, mixed>|string[]|null $orderBy
   * @return User|null
   */
  public function findOneBy(array $criteria, ?array $orderBy = null): ?User
  {
    return $this->repository->findOneBy($criteria, $orderBy);
  }

  /**
   * @return User[]
   */
  public function findAll(): array
  {
    return $this->repository->findAll();
  }

  /**
   * @param array<string, mixed> $criteria
   * @param array<string, mixed>|string[]|null $orderBy
   * @param int|null $limit
   * @param int|null $offset
   * @return User[]
   */
  public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
  {
    return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
  }

  /**
   * Create a password hash.
   *
   * @param string $password
   * @return string
   */
  public function createPasswordHash(string $password): string
  {
    return $this->passwords->hash($password);
  }

  public function forceUpdatePassword(User $user, string $newPassword): User
  {
    $user->setPasswordHash($this->createPasswordHash($newPassword));
    $this->em->persist($user);

    return $user;
  }

  public function updatePassword(User $user, string $oldPassword, string $newPassword): User {
    if (!$this->passwords->verify($oldPassword, $user->getPasswordHash())) {
      throw new UnexpectedValueException("Staré heslo se neshoduje.");
    }

    return $this->forceUpdatePassword($user, $newPassword);
  }

  /**
   * Create a new user from a register form.
   *
   * @param RegisterFormData $data
   * @return User
   */
  public function create(RegisterFormData $data): User
  {
    $user = (new User())
      ->setUsername($data->username)
      ->setPasswordHash($this->createPasswordHash($data->password))
      ->setEmail($data->email);

    $this->em->persist($user);

    // Immediately persist the user in the database.
    $this->em->flush();

    return $user;
  }

}
