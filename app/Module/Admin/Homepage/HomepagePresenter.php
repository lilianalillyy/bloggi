<?php declare(strict_types = 1);

namespace App\Module\Admin\Homepage;

use App\Model\Presenters\Traits\RequiresAuth;
use App\Module\Admin\BaseAdminPresenter;

class HomepagePresenter extends BaseAdminPresenter {

  use RequiresAuth;

}
