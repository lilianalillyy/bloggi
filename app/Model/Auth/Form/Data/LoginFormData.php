<?php declare(strict_types=1);

namespace App\Model\Auth\Form\Data;

class LoginFormData
{

  public function __construct(
    public string $username,
    public string $password
  )
  {
  }

}
