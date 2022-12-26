<?php declare(strict_types = 1);

namespace BloggiSetup;

use Nette\Utils\FileSystem;

class SetupLock {

    public const LOCK_NAME = "setup.lock";

    public static function getPath(): string
    {
        return FileSystem::joinPaths(__DIR__, "..", self::LOCK_NAME);
    } 

    public static function lock(): void
    {
        FileSystem::write(self::getPath(), "");
    }

    public static function unlock(): void
    {
        if (self::exists()) {
            FileSystem::delete(self::getPath());
        }
    }

    public static function exists(): bool
    {
        return file_exists(self::getPath());
    }

}