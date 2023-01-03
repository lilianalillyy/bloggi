<?php declare(strict_types = 1);

namespace App\Module\Admin;

use App\Presenters\BasePresenter;
use App\Module\Admin\BaseAdminTemplate;
use App\Presenters\Traits\RequiresAuth;

/**
 * @property BaseAdminTemplate $template
 */
class BaseAdminPresenter extends BasePresenter
{
  use RequiresAuth;

  public function beforeRender(): void
  {
    parent::beforeRender();
    $this->redrawControl("sidebar");
  }

}
