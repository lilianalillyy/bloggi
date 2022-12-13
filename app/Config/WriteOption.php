<?php declare(strict_types = 1);

namespace App\Config;

enum WriteOption: string {
    case Write = 'write';
    case Merge = 'merge';
}