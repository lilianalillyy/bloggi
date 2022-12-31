<?php declare(strict_types=1);

namespace App\Module\Front\Homepage;

use App\Model\Post\PostFacade;
use App\Model\Sort\Sort;
use App\Module\Front\BaseFrontPresenter;
use App\Presenters\Traits\Sorts;

/**
 * @property HomepageTemplate $template
 */
final class HomepagePresenter extends BaseFrontPresenter
{
  use Sorts;

  public function __construct(
    private readonly PostFacade $postFacade
  )
  {
    parent::__construct();
  }

  public function getSortColumns(): array
  {
    return [
      "created_at" => new Sort("p.createdAt", "DESC"),
      "title" => new Sort("p.title", "DESC"),
    ];
  }

  public function getDefaultSort(): ?Sort
  {
    return $this->getSortColumns()["created_at"];
  }

  public function renderDefault(int $page = 1, ?string $sortBy = null): void
  {
    $sort = $this->getSort($sortBy);

    [$paginator, $posts] = $this->postFacade->paged($page, orderBy: $sort->toArray());

    $this->template->latestPost = count($posts) ? current($posts) : null;
    $this->template->posts = $posts;
    $this->template->paginator = $paginator;
  }

}
