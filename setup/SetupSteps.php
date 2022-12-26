<?php declare(strict_types = 1);

namespace BloggiSetup;

class SetupSteps {

    public static array $steps = [
        ":Setup:DatabaseConfig:default",
        ":Setup:DatabaseMigration:default",
        ":Setup:User:default"
    ];

    public static function first(): string
    {
        return self::$steps[0];
    }

    public static function last(): string
    {
        return self::$steps[sizeof(self::$steps) - 1];
    }

    public static function previous(string $current): ?string
    {
        $currentIndex = array_search($current, self::$steps);
        if ($currentIndex === false) return self::first();

        $previousIndex = $currentIndex - 1;
        if (!isset(self::$steps[$previousIndex])) {
            return null;
        }

        return self::$steps[$previousIndex];
    } 

    public static function next(string $current): ?string
    {
        $currentIndex = array_search($current, self::$steps);
        if ($currentIndex === false) return self::first();

        $nextIndex = $currentIndex + 1;
        if (!isset(self::$steps[$nextIndex])) {
            return null;
        }

        return self::$steps[$nextIndex];
    }

}