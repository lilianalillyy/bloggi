<?php declare(strict_types = 1);

namespace App\Config;

use App\Exception\NotImplementedException;
use ReflectionClass;

abstract class Configurator {

    public function write(string $fileName, array $content, WriteOption $writeOption = WriteOption::Merge): void {
        $className = (new ReflectionClass($this))->getShortName();
        throw new NotImplementedException("$className::write() is not implemented.");
    } 

    public function read(string $fileName): array {
        $className = (new ReflectionClass($this))->getShortName();
        throw new NotImplementedException("$className::read() is not implemented.");
    }

}