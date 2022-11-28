<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\Security;

use Nette\Security\Passwords as NettePasswords;

/**
 * The hashing class, descendant of the Nette Passwords class.
 */
class Passwords extends NettePasswords
{

  /**
   * @param string $algo
   * @param array<string, mixed> $options
   */
  public function __construct(string $algo, array $options = [])
  {
    parent::__construct($algo, $options);
  }

}
