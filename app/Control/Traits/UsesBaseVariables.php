<?php declare(strict_types = 1);

namespace App\Control\Traits;

trait UsesBaseVariables
{

    public function setBaseVariables()
    {
        $this->template->loggedUser = $this->presenter->getLoggedUser();
        $this->template->userIdentity = $this->presenter->getUserIdentity();
        $this->template->user = $this->presenter->getUser();
        $this->template->presenter = $this->presenter;
    }

}