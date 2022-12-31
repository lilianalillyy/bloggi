<?php declare(strict_types=1);

namespace App\Module\Front\Post;

use App\Model\Post\Comment\PostCommentFacade;
use App\Model\Post\Form\Data\PostCommentFormData;
use App\Model\Post\Form\PostCommentFormFactory;
use App\Model\Post\Post;
use App\Model\Post\PostFacade;
use App\Model\Post\Rating\PostRatingControl;
use App\Model\Post\Rating\PostRatingFacade;
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

  private ?Post $post = null;

  public function __construct(
    private readonly PostFacade $postFacade,
    private readonly PostRatingFacade $ratingFacade,
    private readonly PostCommentFacade $commentFacade,
    private readonly PostCommentFormFactory $postCommentFormFactory
  )
  {
    parent::__construct();
  }

  public function getPost(): Post {
    if ($this->post) return $this->post;

    $post = $this->postFacade->find($this->getParameter("id"));

    if (!$post) {
      $this->error();
    }

    return $this->post = $post;
  }

  public function renderView(string $id): void
  {
    $this->template->post = $this->getPost();
    $this->template->comments = $this->getPost()->getComments();
  }

  public function createComponentPostRating(): PostRatingControl
  {
    return new PostRatingControl($this->getPost());
  }

  public function createComponentCommentForm(): Form {
    $form = $this->postCommentFormFactory->create();

    $form->onSuccess[] = function (Form $_, PostCommentFormData $data) {
      try {
        $this->commentFacade->create($data, $this->getPost(), $this->getLoggedUserOrFail());
        $this->flashMessage("Komentář přidán.");
      } catch (Exception $e) {
        $this->flashMessage($e->getMessage(), 'danger');
      }  
    };

    return $form;
  }

}
