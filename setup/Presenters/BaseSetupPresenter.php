<?php declare(strict_types=1);

namespace BloggiSetup\Presenters;

use BloggiSetup\SetupLock;
use Nette\Application\UI\Presenter;

/**
 * @property BaseSetupTemplate $template
 */
class BaseSetupPresenter extends Presenter
{

  public function startup() {
    parent::startup();

    if (SetupLock::exists()) {
      $this->redirectPermanent("/");
    }
  }

}
