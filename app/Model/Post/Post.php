<?php declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Database\Traits\TimestampableTrait;
use App\Model\Database\Traits\UuidTrait;
use App\Model\Post\Comment\PostComment;
use App\Model\Post\Rating\PostRating;
use App\Utils\Arrays\ArrayExpressible;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: 'posts')]
class Post extends ArrayExpressible
{

  use UuidTrait;
  use TimestampableTrait;

  #[ORM\Column(name: 'title', type: 'string', length: 255)]
  private string $title;

  #[ORM\Column(length: 255, unique: true)]
  #[Gedmo\Slug(fields: ['title'])]
  private string $slug;

  #[ORM\Column(name: 'perex', type: 'string')]
  private string $perex;

  #[ORM\Column(name: 'content', type: 'text')]
  private string $content;

  /**
   * @var Collection<string, PostRating>
   */
  #[ORM\OneToMany(mappedBy: 'post', targetEntity: PostRating::class)]
  private Collection $ratings;

  /**
   * @var Collection<string, PostComment>
   */
  #[ORM\OneToMany(mappedBy: 'post', targetEntity: PostComment::class)]
  private Collection $comments;

  public function __construct()
  {
    $this->ratings = new ArrayCollection();
  }

  /**
   * @return string
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @param string $title
   * @return Post
   */
  public function setTitle(string $title): self
  {
    $this->title = $title;
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
   * @return Post
   */
  public function setSlug(string $slug): self
  {
    $this->slug = $slug;
    return $this;
  }

  /**
   * @return string
   */
  public function getPerex(): string
  {
    return $this->perex;
  }

  /**
   * @param string $perex
   * @return Post
   */
  public function setPerex(string $perex): Post
  {
    $this->perex = $perex;
    return $this;
  }

  /**
   * @return string
   */
  public function getContent(): string
  {
    return $this->content;
  }

  /**
   * @param string $content
   * @return Post
   */
  public function setContent(string $content): Post
  {
    $this->content = $content;
    return $this;
  }

  /**
   * @return Collection<string, PostRating>
   */
  public function getRatings(): Collection
  {
    return $this->ratings;
  }

  /**
   * @param Collection<string, PostRating> $ratings
   * @return Post
   */
  public function setRatings(Collection $ratings): Post
  {
    $this->ratings = $ratings;
    return $this;
  }

  /**
   * @return Collection<string, PostComment>
   */
  public function getComments(): Collection
  {
    return $this->comments;
  }

  /**
   * @param Collection<string, PostComment> $comments
   * @return Post
   */
  public function setComments(Collection $comments): Post
  {
    $this->comments = $comments;
    return $this;
  }

}
