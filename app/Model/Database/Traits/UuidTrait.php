<?php declare(strict_types=1);

namespace App\Model\Database\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

trait UuidTrait
{

  #[ORM\Id]
  #[ORM\Column(type: "uuid", nullable: false)]
  #[ORM\GeneratedValue(strategy: "CUSTOM")]
  #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
  private string $id;

  /**
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * @param string $id
   */
  public function setId(string $id): void
  {
    $this->id = $id;
  }

}
