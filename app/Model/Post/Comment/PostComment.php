<?php declare(strict_types = 1);

namespace App\Model\Post\Comment;

use App\Model\Database\Traits\TimestampableTrait;
use App\Model\Database\Traits\UuidTrait;
use App\Model\Post\Post;
use App\Model\User\User;
use App\Utils\Arrays\ArrayExpressible;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCommentRepository::class)]
#[ORM\Table(name: 'posts_comments')]
class PostComment extends ArrayExpressible
{

  use UuidTrait;
  use TimestampableTrait;

  #[ORM\Column(name: 'kind', type: 'text', length: 1024)]
  private string $content;

  #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'comments')]
  #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'id')]
  private Post $post;

  #[ORM\ManyToOne(targetEntity: User::class)]
  #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
  private User $user;

  public function getContent(): string
  {
    return $this->content;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;
    return $this;
  }

  public function getPost(): Post
  {
    return $this->post;
  }

  public function setPost(Post $post): self
  {
    $this->post = $post;
    return $this;
  }

  public function getUser(): User
  {
    return $this->user;
  }

  public function setUser(User $user): self
  {
    $this->user = $user;
    return $this;
  }

}