<?php declare(strict_types=1);

namespace App\Module\Setup;

use Nette\Application\UI\Presenter;

/**
 * @property BaseSetupTemplate $template
 */
class BaseSetupPresenter extends Presenter
{

  public function startup() {
    parent::startup();

    // TODO: lock check
  }

}
