<?php declare(strict_types=1);

namespace App\Model\Auth\Form\Data;

class RegisterFormData
{

  public function __construct(
    public string $username,
    public string $email,
    public string $password,
    public string $repeatPassword
  )
  {
  }

}
