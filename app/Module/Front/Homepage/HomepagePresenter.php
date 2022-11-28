<?php declare(strict_types=1);

namespace App\Module\Front\Homepage;

use App\Model\Post\PostFacade;
use App\Module\Front\BaseFrontPresenter;

/**
 * @property HomepageTemplate $template
 */
final class HomepagePresenter extends BaseFrontPresenter
{

  public function __construct(
    private readonly PostFacade $postFacade
  )
  {
    parent::__construct();
  }

  public const SORT_POSTS_BY = [
    "created_at",
    "title",
  ];

  public const DEFAULT_SORT = ["created_at", "p.createdAt"];

  public function renderDefault(int $page = 1, string $sortBy = self::DEFAULT_SORT[0]): void
  {
    if (!in_array($sortBy, self::SORT_POSTS_BY)) {
      $sortBy = self::DEFAULT_SORT[0];
    }

    $orderBy = match ($sortBy) {
      'created_at' => "p.createdAt",
      'title' => "p.title",
      default => self::DEFAULT_SORT[1]
    };

    [$paginator, $posts] = $this->postFacade->paged($page, orderBy: $orderBy);

    $this->template->latestPost = count($posts) ? current($posts) : null;
    $this->template->posts = $posts;
    $this->template->paginator = $paginator;
  }

}
