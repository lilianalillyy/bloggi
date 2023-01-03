<?php declare(strict_types=1);

namespace App\Model\Post;

use App\Exception\InvalidArgumentException;
use App\Model\Database\EntityManager;
use App\Model\Post\Form\Data\PostFormData;
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

  public function remove(string $id): ?Post
  {
    $post = $this->repository->find($id);

    if (!$post) {
      return null;
    }

    $ratings = $this->em->postRating()->findBy([ "post" => $post ]);

    foreach ($ratings as $rating) {
      $this->em->remove($rating);
    }

    $comments = $this->em->postComment()->findBy([ "post" => $post ]);

    foreach ($comments as $comment) {
      $this->em->remove($comment);
    }

    $this->em->remove($post);
    $this->em->flush();

    return $post;
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

  public function paged(int $page = 1, int $showPerPage = 5, array $criteria = [], array $orderBy = []): array
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
      if (count($orderBy) < 2) {
        throw new InvalidArgumentException('$orderBy must be an array in format [columnName, direction]');
      }

      $qb->orderBy($orderBy[0], $orderBy[1]);
    }

    $posts = $qb->getQuery()->getResult();

    return [$paginator, $posts];
  }

  public function create(PostFormData $data): Post
  {
    $post = new Post();

    $post->setTitle($data->title)
      ->setPerex($data->perex)
      ->setContent($data->content);

    $this->em->persist($post);
    $this->em->flush($post);

    return $post;
  }

}
