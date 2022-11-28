<?php declare(strict_types=1);

namespace App\Module\Front\Error4xx;

use App\Module\Front\BaseFrontPresenter;
use Nette\Application\BadRequestException;
use Nette\Application\Request;

final class Error4XxPresenter extends BaseFrontPresenter
{
  public function startup(): void
  {
    parent::startup();

    if (!$this->getRequest()?->isMethod(Request::FORWARD)) {
      $this->error();
    }
  }

  public function renderDefault(BadRequestException $exception): void
  {
    $this->template->exception = $exception;
    $this->template->setFile(__DIR__ . '/../templates/Error/4xx.latte');
  }
}
