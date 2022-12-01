<?php declare(strict_types=1);

namespace App\Presenters\Traits;

use App\Templating\TemplateHelper;
use Nette\Application\Helpers;
use Nette\Utils\FileSystem;

trait UsesTemplating
{

  private TemplateHelper $templateHelper;

  public function injectTemplateHelper(TemplateHelper $helper): void
  {
    $this->templateHelper = $helper;
  }

  /**
   * Formats layout template file names.
   */
  public function formatLayoutTemplateFiles(): array
  {
    if (preg_match('#/|\\\\#', (string) $this->layout)) {
      return [$this->layout];
    }

    $themeRoot = $this->templateHelper->getThemeRoot();
    $presenterRoot = $this->templateHelper->getRelativePresenterRoot($this);
    $layout = $this->layout ?: 'layout';
    [$module, $presenter] = Helpers::splitName($this->getName() ?? '');

    $list = array_map(fn($path) => FileSystem::normalizePath($path), [
      "$themeRoot/$presenterRoot/@$layout.latte",
      "$themeRoot/$presenterRoot/$presenter.@$layout.latte",
      "$themeRoot/$module/$presenter.@$layout.latte",
      "$themeRoot/$module/@$layout.latte",
      "$themeRoot/@$layout.latte"
    ]);

    return $list;
  }


  /**
   * Formats view template file names.
   */
  public function formatTemplateFiles(): array
  {
    $themeRoot = $this->templateHelper->getThemeRoot();
    $presenterRoot = $this->templateHelper->getRelativePresenterRoot($this);
    $template = $this->templateHelper->getRelativeTemplate($this);
    $view = $this->getView();
    [$module, $presenter] = Helpers::splitName($this->getName());

    return array_map(fn($path) => FileSystem::normalizePath($path), [
      "$themeRoot/$template.latte",
      "$themeRoot/$presenterRoot/$view.latte",
      "$themeRoot/$module/$presenter.$view.latte"
    ]);
  }

}
