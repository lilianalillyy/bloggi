<?php declare(strict_types=1);

namespace App\Module\Front\Post;

use App\Model\Post\Comment\PostComment;
use App\Model\Post\Post;
use App\Module\Front\BaseFrontTemplate;
use Doctrine\Common\Collections\Collection;

class PostTemplate extends BaseFrontTemplate
{

  public Post $post;

  /**
   * @var Collection<string, PostComment>
   */
  public Collection $comments;

  public int $likes;

  public int $dislikes;

}
