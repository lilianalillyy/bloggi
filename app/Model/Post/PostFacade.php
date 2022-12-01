<?php declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Database\EntityManager;
use Nette\Utils\Paginator;

class PostFacade
{

  private readonly PostRepository $repository;

  public function __construct(
    public readonly EntityManager $em
  )
  {
    $this->repository = $em->post();
  }

  /**
   * @param string $id
   * @return Post|null
   */
  public function find(string $id): ?Post
  {
    return $this->repository->find($id);
  }

  /**
   * @param array<string, mixed> $criteria
   * @param array<string, mixed>|string[]|null $orderBy
   * @return Post|null
   */
  public function findOneBy(array $criteria, ?array $orderBy = null): ?Post
  {
    return $this->repository->findOneBy($criteria, $orderBy);
  }

  /**
   * @return Post[]
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
   * @return Post[]
   */
  public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
  {
    return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
  }

  public function paged(int $page = 1, int $showPerPage = 5, array $criteria = [], ?string $orderBy = null): array
  {
    $paginator = new Paginator();
    $paginator
      ->setItemCount($this->repository->count($criteria))
      ->setPage($page)
      ->setItemsPerPage($showPerPage);

    $qb = $this->repository->createQueryBuilder("p")
      ->select("p")
      ->setMaxResults($paginator->getLength())
      ->setFirstResult($paginator->getOffset());

    if ($orderBy) {
      $qb->orderBy($orderBy, "DESC");
    }

    $posts = $qb->getQuery()->getResult();

    return [$paginator, $posts];
  }

}
