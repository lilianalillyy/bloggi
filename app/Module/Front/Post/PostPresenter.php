<?php declare(strict_types=1);

namespace App\Module\Front\Post;

use App\Model\Post\Post;
use App\Model\Post\PostFacade;
use App\Model\Post\Rating\PostRating;
use App\Model\Post\Rating\PostRatingFacade;
use App\Model\Post\Rating\PostRatingKind;
use App\Model\Presenters\Traits\RequiresAuth;
use App\Module\Front\BaseFrontPresenter;

class PostPresenter extends BaseFrontPresenter
{
  use RequiresAuth;

  public function __construct(
    private readonly PostFacade $postFacade,
    private readonly PostRatingFacade $ratingFacade,
  )
  {
    parent::__construct();
  }

  public function findOrFail(?string $id = null): Post {
    $post = $this->postFacade->find($id ?? $this->getParameter("id"));

    if (!$post) {
      $this->error();
    }

    return $post;
  }

  public function renderView(string $id): void
  {
    $post = $this->findOrFail($id);

    $this->template->post = $post;
    $this->template->likes = $post->getRatings()->filter(fn (PostRating $rating) => $rating->isLike())->count();
    $this->template->dislikes = $post->getRatings()->filter(fn (PostRating $rating) => $rating->isDislike())->count();
  }

  public function handleLike(string $id): void
  {
    $post = $this->findOrFail($id);

    $this->ratingFacade->ratePost($post, $this->getLoggedUserOrFail(), PostRatingKind::Like);

    $this->redirect(":view", ["id" => $id]);
  }

  public function handleDislike(string $id): void
  {
    $post = $this->findOrFail($id);

    $this->ratingFacade->ratePost($post, $this->getLoggedUserOrFail(), PostRatingKind::Dislike);

    $this->redirect(":view", ["id" => $id]);
  }

}
