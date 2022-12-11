<?php declare(strict_types=1);

namespace App\Model\Post\Comment;

use App\Model\Database\EntityManager;
use App\Model\Post\Form\Data\PostCommentFormData;
use App\Model\Post\Post;
use App\Model\User\User;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\NoResultException;

class PostCommentFacade
{

  private readonly PostCommentRepository $repository;

  public function __construct(
    public readonly EntityManager $em
  )
  {
    $this->repository = $em->getRepository(PostComment::class);
  }

  /**
   * @param string $id
   * @return PostComment|null
   */
  public function find(string $id): ?PostComment
  {
    return $this->repository->find($id);
  }

  /**
   * @param array<string, mixed> $criteria
   * @param array<string, mixed>|string[]|null $orderBy
   * @return PostComment|null
   */
  public function findOneBy(array $criteria, ?array $orderBy = null): ?PostComment
  {
    return $this->repository->findOneBy($criteria, $orderBy);
  }

  /**
   * @return PostComment[]
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
   * @return PostComment[]
   */
  public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
  {
    return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
  }

  public function commentPost(Post $post, User $user, string $content): PostComment
  {
    $comment = (new PostComment())
        ->setPost($post)
        ->setUser($user)
        ->setContent($content);

    $this->em->persist($comment);
    $this->em->flush();

    return $comment;
  }

  public function create(PostCommentFormData $data, Post $post, User $user): PostComment
  {
    return $this->commentPost($post, $user, $data->content);
  }

}
