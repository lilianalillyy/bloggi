<?php declare(strict_types = 1);

namespace App\Module\Front\Post;

use App\Model\Post\Post;
use App\Module\Front\BaseFrontTemplate;

class PostTemplate extends BaseFrontTemplate {

  public Post $post;

  public int $likes;

  public int $dislikes;

}
