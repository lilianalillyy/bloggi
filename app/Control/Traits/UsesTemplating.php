<?php declare(strict_types = 1);

namespace App\Control\Traits;

use Nette\Application\UI\Control;
use Nette\Utils\FileSystem;

trait UsesTemplating
{

    public function getTemplatePath(string $name): string
    {
        assert($this instanceof Control);

        $presenterTemplate = $this->presenter->template->getFile();

        if (!$presenterTemplate) return "/$name";

        return FileSystem::normalizePath("$presenterTemplate/../_$name.latte");
    }

}