<?php declare(strict_types=1);

namespace BloggiSetup\Presenters;

use BloggiSetup\SetupLock;
use BloggiSetup\SetupSteps;
use Nette\Application\UI\Presenter;
use Nette\DI\Attributes\Inject;
use Nette\DI\Container;

/**
 * @property BaseSetupTemplate $template
 */
class BaseSetupPresenter extends Presenter
{

  #[Inject]
  public Container $container;

  public function startup() 
  {
    parent::startup();

    if (SetupLock::exists()) {
      $this->redirectUrl("/");
    }

    if (!in_array($this->getAction(true), SetupSteps::$steps)) {
      $this->redirect(SetupSteps::first());
    }
  }

  public function previousStep() 
  {
    $route = SetupSteps::previous($this->getAction(true));
    if (!$route) $route = SetupSteps::first();

    $this->redirect($route);
  }

  public function nextStep()
  {
    $route = SetupSteps::next($this->getAction(true));
    if (!$route) return $this->finishSetup();

    $this->redirect($route);
  }

  public function finishSetup() 
  {
    SetupLock::lock();
    $this->redirectUrl("/");
  }

}
