<?php declare(strict_types=1);

namespace App\Model\Database\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampableTrait
{

  #[ORM\Column(name: 'created_at', type: 'datetime')]
  #[Gedmo\Timestampable(on: 'create')]
  private DateTime $createdAt;

  #[ORM\Column(name: 'updated_at', type: 'datetime')]
  #[Gedmo\Timestampable(on: 'update')]
  private DateTime $updatedAt;

  /**
   * @return DateTime
   */
  public function getCreatedAt(): DateTime
  {
    return $this->createdAt;
  }

  /**
   * @return DateTime
   */
  public function getUpdatedAt(): DateTime
  {
    return $this->updatedAt;
  }

  /**
   * @param DateTime $updatedAt
   */
  public function setUpdatedAt(DateTime $updatedAt): void
  {
    $this->updatedAt = $updatedAt;
  }

}
