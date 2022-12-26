<?php declare(strict_types=1);

namespace App\Config\Neon;

use App\Config\Writer;
use App\Config\WriteOption;
use Nette\Neon\Neon;
use Nette\Utils\Arrays;
use Nette\Utils\FileSystem;
use RuntimeException;

class NeonWriter extends Writer
{

  public function __construct(private string $baseDir)
  {
  }

  private function createPath(string $fileName): string
  {
    $baseDir = $this->baseDir;
    return FileSystem::normalizePath("$baseDir/$fileName.neon");
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
      WriteOption::Merge => Arrays::mergeTree($content, $config)
    };

    $path = $this->createPath($fileName);

    if (!is_writable($path)) {
      throw new RuntimeException("Cannot write to '$path'");
    }

    FileSystem::write($path, Neon::encode($config, true));
  }

}
