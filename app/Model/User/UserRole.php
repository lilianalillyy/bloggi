<?php declare(strict_types=1);

namespace App\Model\User;

enum UserRole: string
{
  case User = 'user';
  case Admin = 'admin';
  case Superadmin = 'superadmin';
}
