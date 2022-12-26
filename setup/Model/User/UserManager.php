<?php declare(strict_types = 1);

namespace BloggiSetup\Model\User;

use App\Model\Auth\Form\Data\RegisterFormData;
use App\Model\Database\EntityManager;
use App\Model\User\User;
use App\Model\User\UserFacade;

class UserManager {

    public function __construct(
        private UserFacade $userFacade,
        private EntityManager $em
    ) {
    }

    public function setup(RegisterFormData $data) 
    {
        $user = $this->userFacade->create($data);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

}