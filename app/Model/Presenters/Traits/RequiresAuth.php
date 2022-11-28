<?php declare(strict_types = 1);

namespace App\Model\Presenters\Traits;

use Nette\Application\UI\Presenter;

trait RequiresAuth {

  use ManagesSnippets;

  public function injectRequiresAuth(): void
  {
    $this->onStartup[] = fn (...$params) => $this->validateAuth(...$params);
  }

  private function validateAuth(): void
  {
    /** @var Presenter $self */
    $self = $this;

    if (!$self->getUser()->isLoggedIn()) {
      $this->forceRedirect();
      $self->redirect(":Security:Auth:login", ['backlink' => $this->storeRequest()]);
    }
  }

}
