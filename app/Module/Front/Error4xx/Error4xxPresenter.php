<?php declare(strict_types=1);

namespace App\Module\Front\Error4xx;

use App\Module\Front\BaseFrontPresenter;
use Nette\Application\BadRequestException;
use Nette\Application\Request;

/**
 * @property Error4xxTemplate $template
 */
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
    $this->template->code = $exception->getHttpCode();

    // TODO: i18n
    $this->template->message = match ($exception->getHttpCode()) {
      401 => "You are not authorized to see this page.",
      403 => "You must be logged in to see this page.",
      404 => "Page not found.",
      default => "An error has occurred."
    };
  }
}
