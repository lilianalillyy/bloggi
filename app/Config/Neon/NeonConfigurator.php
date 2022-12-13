<?php declare(strict_types = 1);

namespace App\Config\Neon;

use App\Config\Configurator;
use App\Config\WriteOption;
use Latte\Runtime\Defaults;
use Nette\Neon\Neon;
use Nette\Utils\Arrays;
use Nette\Utils\FileSystem;
use RuntimeException;

class NeonConfigurator extends Configurator {

    public function __construct(private string $baseDir) {
    }

    private function createPath(string $fileName): string {
        $baseDir = $this->baseDir;
        return FileSystem::normalizePath("nette.safe://$baseDir/$fileName.neon");
    }

    public function read(string $fileName): array
    {
        return Neon::decodeFile($this->createPath($fileName));
    }

    public function write(string $fileName, array $content, WriteOption $writeOption = WriteOption::Merge): void
    {
        $config = $this->read($fileName);

        $config = match ($writeOption) {
            WriteOption::Write => $content,
            WriteOption::Merge => Arrays::mergeTree($config, $content)
        };

        $path = $this->createPath($fileName);

        if (!is_writable($path)) {
            throw new RuntimeException("Cannot write to '$path'");
        }

        FileSystem::write($path, Neon::encode($path, true));
    }

}