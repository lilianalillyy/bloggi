<?php declare(strict_types = 1);

namespace App\Model\Presenters\Traits;

trait ManagesSnippets {

  public function forceRedirect(bool $forceRedirect = true): static
  {
    $this->payload->forceRedirect = $forceRedirect;
    return $this;
  }

  public function redirectPayload(?string $redirect): static
  {
    $this->payload->redirect = $redirect ? $this->link($redirect) : null;
    return $this;
  }

}
