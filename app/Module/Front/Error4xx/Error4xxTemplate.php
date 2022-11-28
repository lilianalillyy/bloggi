<?php declare(strict_types = 1);

namespace App\Module\Front\Error4xx;

use App\Module\Front\BaseFrontTemplate;
abstract class Error4xxTemplate extends BaseFrontTemplate
{
  public int $code;

  public string $message;

}
