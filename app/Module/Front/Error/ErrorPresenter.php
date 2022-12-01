<?php declare(strict_types=1);

namespace App\Module\Front\Error;

use App\Templating\TemplateHelper;
use Nette\Application\BadRequestException;
use Nette\Application\Helpers;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Nette\SmartObject;
use Tracy\ILogger;
use function str_contains;

final class ErrorPresenter implements IPresenter
{
  use SmartObject;

  public function __construct(
    private readonly ILogger $logger,
    private readonly TemplateHelper $templateHelper
  )
  {
  }

  public function run(Request $request): Response
  {
    $exception = $request->getParameter('exception');

    [$module, $presenter, $sep] = Helpers::splitName($request->getPresenterName());

    if ($exception instanceof BadRequestException) {
      return new ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
    }

    $this->logger->log($exception, ILogger::EXCEPTION);

    return new CallbackResponse(function (IRequest $request, IResponse $response) use ($module, $presenter): void {
      if (str_contains($request->getHeader('Content-Type') ?? 'text/html', "text/html")) {
        require $this->templateHelper->getThemeRoot() . "/$module/$presenter/500.phtml";
      }
    });
  }
}
