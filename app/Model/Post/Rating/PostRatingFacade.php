<?php declare(strict_types=1);

namespace App\Model\Post\Rating;

use App\Model\Database\EntityManager;
use App\Model\Post\Post;
use App\Model\User\User;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\NoResultException;

class PostRatingFacade
{

  private readonly PostRatingRepository $repository;

  public function __construct(
    public readonly EntityManager $em
  )
  {
    $this->repository = $em->getRepository(PostRating::class);
  }

  /**
   * @param string $id
   * @return PostRating|null
   */
  public function find(string $id): ?PostRating
  {
    return $this->repository->find($id);
  }

  /**
   * @param array<string, mixed> $criteria
   * @param array<string, mixed>|string[]|null $orderBy
   * @return PostRating|null
   */
  public function findOneBy(array $criteria, ?array $orderBy = null): ?PostRating
  {
    return $this->repository->findOneBy($criteria, $orderBy);
  }

  /**
   * @return PostRating[]
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
   * @return PostRating[]
   */
  public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
  {
    return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
  }

  public function countRatings(string $postId, ?PostRatingKind $kind = PostRatingKind::Like): int
  {
    return $this->repository->count(['post' => $postId, 'kind' => $kind]);
  }

  public function ratePost(Post $post, User $user, PostRatingKind $kind): ?PostRating
  {
    $this->em->beginTransaction();
    
    $qb = $this->repository
    ->createQueryBuilder('pr')
    ->where('pr.post = :post')
    ->andWhere('pr.user = :user')
    ->setParameters([
      "post" => $post->getId(),
      "user" => $user->getId(),
    ]);

    try {
      /** @var PostRating $rating */
      $rating = $qb->getQuery()
      ->setLockMode(LockMode::PESSIMISTIC_WRITE)
      ->getSingleResult();

      // If asked to rate post and the same rating already exists, remove rating.
      if ($rating && $rating->kind === $kind) {
        $this->em->remove($rating);
        $this->em->commit();
        return null;
      }
    } catch (NoResultException) {
      $rating = (new PostRating())
      ->setPost($post)
      ->setUser($user);
    }

    $rating->setKind($kind);

    $this->em->persist($rating);
    $this->em->commit();

    return $rating;
  }

}
