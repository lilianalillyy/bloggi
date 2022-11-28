<?php declare(strict_types=1);

namespace App\Model\Post\Rating;

use App\Model\Database\Traits\TimestampableTrait;
use App\Model\Database\Traits\UuidTrait;
use App\Model\Post\Post;
use App\Model\User\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRatingRepository::class)]
#[ORM\Table(name: 'posts_ratings')]
class PostRating
{

  use UuidTrait;
  use TimestampableTrait;

  #[ORM\Column(name: 'kind', type: 'string', enumType: PostRatingKind::class)]
  public PostRatingKind $kind;

  #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'ratings')]
  #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id')]
  public Post $post;

  #[ORM\ManyToOne(targetEntity: User::class)]
  #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
  public User $user;

  /**
   * @return PostRatingKind
   */
  public function getKind(): PostRatingKind
  {
    return $this->kind;
  }

  /**
   * @param PostRatingKind $kind
   * @return PostRating
   */
  public function setKind(PostRatingKind $kind): PostRating
  {
    $this->kind = $kind;
    return $this;
  }

  public function isLike(): bool
  {
    return $this->getKind() === PostRatingKind::Like;
  }

  public function isDislike(): bool
  {
    return $this->getKind() === PostRatingKind::Dislike;
  }

  /**
   * @param Post $post
   * @return PostRating
   */
  public function setPost(Post $post): PostRating
  {
    $this->post = $post;
    return $this;
  }

  /**
   * @param User $user
   * @return PostRating
   */
  public function setUser(User $user): PostRating
  {
    $this->user = $user;
    return $this;
  }

}
