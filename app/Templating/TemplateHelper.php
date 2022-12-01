<?php declare(strict_types = 1);

namespace App\Templating;

use Nette\Application\UI\Presenter;
use Nette\Utils\FileSystem;

class TemplateHelper {

    public function __construct(
        public string $theme = "default", 
        public string $baseDir = "/"
    )
    {
    }

    public function getThemeRoot(): string
    {
        return FileSystem::normalizePath(sprintf("%s/%s", $this->baseDir, $this->theme));
    }

    public function getRelativePresenterRoot(Presenter $presenter): string
    {
        // Replaces module:presenter separator with a path separator.
        // This way non-moduled presenters can be used as well.
        $presenterName = str_replace(":", "/", $presenter->getName() ?? '');

        return FileSystem::normalizePath($presenterName);
    }

    public function getRelativeTemplate(Presenter $presenter): string
    {
        return FileSystem::normalizePath(sprintf("%s/%s", $this->getRelativePresenterRoot($presenter), $presenter->getView()));
    }

}