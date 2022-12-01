<?php declare(strict_types=1);

namespace App\Utils\Arrays;

use App\Exception\UnexpectedValueException;
use function property_exists;

/**
 * Allows for the extending class to be converted to an array
 * and for data to be filled from an array.
 */
abstract class ArrayExpressible
{

  /**
   * Converts the object to an array.
   *
   * @return array<string,mixed>
   */
  public function toArray(): array
  {
    return get_object_vars($this);
  }

  /**
   * Fill out the object with data from the object.
   *
   * @throws UnexpectedValueException If a key in an object is not a defined property
   * @param array<string,mixed>
   */
  public function fromArray(array $data): void
  {
    foreach ($data as $key => $value) {
      if (!property_exists($this, $key)) {
        throw new UnexpectedValueException("Unexpected property: '$key'");
      }

      $this->$key = $value;
    }
  }

}
