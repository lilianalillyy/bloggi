<?php declare(strict_types = 1);

namespace App\Model\Post\Rating;

use App\Control\Traits\UsesBaseVariables;
use App\Control\Traits\UsesTemplating;
use App\Model\Post\Post;
use Nette\Application\UI\Control;

class PostRatingControl extends Control
{
    use UsesTemplating;
    use UsesBaseVariables;

    public function __construct(
        private Post $post,
    ) {
    }

    public function render(): void
    {
      $this->setBaseVariables();

      $this->template->post = $this->post;
      $this->template->likes = $this->post->getRatings()->filter(fn (PostRating $rating) => $rating->isLike())->count();
      $this->template->dislikes = $this->post->getRatings()->filter(fn (PostRating $rating) => $rating->isDislike())->count();

      $this->template->render($this->getTemplatePath("postRating"));
    }

    public function handleLike(): void
    {
      $this->postRatingFacade->ratePost($this->post, $this->presenter->getLoggedUserOrFail(), PostRatingKind::Like);
    }
  
    public function handleDislike(): void
    {
      $this->postRatingFacade->ratePost($this->post, $this->presenter->getLoggedUserOrFail(), PostRatingKind::Dislike);
    }
}