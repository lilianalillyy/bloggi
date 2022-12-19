<?php declare(strict_types = 1);

namespace App;

enum BootMode: string {
    case Cli = "cli";
    case Web = "web";
}