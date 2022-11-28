<?php declare(strict_types=1);

namespace App\Module\Front\Homepage;

use App\Model\Post\Post;
use App\Module\Front\BaseFrontTemplate;
use Nette\Utils\Paginator;

class HomepageTemplate extends BaseFrontTemplate
{

  public ?Post $latestPost;

  public Paginator $paginator;

  /**
   * @var Post[]
   */
  public array $posts;

}
