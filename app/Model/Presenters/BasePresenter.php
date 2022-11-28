<?php declare(strict_types = 1);

namespace App\Model\Presenters;

use App\Model\Database\EntityManager;
use Nette\Application\Response;
use Nette\Application\UI\Presenter;
use App\Model\Presenters\Traits\Redraws;
use App\Model\Presenters\Traits\ManagesUsers;
use Nette\DI\Attributes\Inject;

/**
 * @property BaseTemplate $template
 */
class BasePresenter extends Presenter {

  use Redraws;
  use ManagesUsers;

  public const DEFAULT_REDRAW = [
    "title",
    "content"
  ];

  #[Inject]
  public EntityManager $em;

  public function beforeRender(): void
  {
    // Inject base template variables
    $this->template->loggedUser = $this->getLoggedUser();
    $this->template->userIdentity = $this->getUserIdentity();
    $this->template->user = $this->getUser();
    $this->template->presenter = $this;

    // Redraw default controls.
    foreach (self::DEFAULT_REDRAW as $control) {
      $this->redrawControl($control);
    }

    parent::beforeRender();
  }

  protected function shutdown(Response $response)
  {
    /**
     * Flush all persisted changes to the database.
     */
    $this->em->flush();

    parent::shutdown($response);
  }

}
