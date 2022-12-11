<?php declare(strict_types=1);

namespace App\Module\Front\Post;

use App\Model\Post\Comment\PostCommentFacade;
use App\Model\Post\Form\Data\PostCommentFormData;
use App\Model\Post\Form\PostCommentFormFactory;
use App\Model\Post\Post;
use App\Model\Post\PostFacade;
use App\Model\Post\Rating\PostRating;
use App\Model\Post\Rating\PostRatingFacade;
use App\Model\Post\Rating\PostRatingKind;
use App\Presenters\Traits\RequiresAuth;
use App\Module\Front\BaseFrontPresenter;
use Exception;
use Nette\Application\UI\Form;

/**
 * @property PostTemplate $template
 */
class PostPresenter extends BaseFrontPresenter
{
  use RequiresAuth;

  public function __construct(
    private readonly PostFacade $postFacade,
    private readonly PostRatingFacade $ratingFacade,
    private readonly PostCommentFacade $commentFacade,
    private readonly PostCommentFormFactory $postCommentFormFactory
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
    $this->template->comments = $post->getComments();
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

  public function createComponentCommentForm(): Form {
    $form = $this->postCommentFormFactory->create();

    $form->onSuccess[] = function (Form $_, PostCommentFormData $data) {
      $post = $this->findOrFail();

      try {
        $this->commentFacade->create($data, $post, $this->getLoggedUserOrFail());
        $this->flashMessage("Komentář přidán.");
      } catch (Exception $e) {
        $this->flashMessage($e->getMessage(), 'danger');
      }  
    };

    return $form;
  }

}
