<?php declare(strict_types=1);

namespace App\Presenters\Traits;

trait Redraws
{

  /**
   * @var string[]
   */
  private array $toBeRedrawn = [];

  /**
   * Get all controls that are going to be redrawn.
   *
   * @return string[]
   */
  public function getControlsToBeRedrawn(): array
  {
    return $this->toBeRedrawn;
  }

  /**
   * Modified redrawControl that saves all controls that are
   * to be redrawn into an array.
   */
  public function redrawControl(?string $snippet = null, bool $redraw = true): void
  {
    if ($redraw && $snippet) {
      $this->toBeRedrawn[] = $snippet;
    }
    
    parent::redrawControl($snippet, $redraw);
  }

  /**
   * Only redraws one single control without redrawing others.
   *
   * @param string $snippet
   * @return void
   */
  public function redrawSingleControl(string $snippet): void
  {
    foreach ($this->toBeRedrawn as $control) {
      $this->redrawControl($control, false);
    }

    $this->redrawControl($snippet);
  }

}
