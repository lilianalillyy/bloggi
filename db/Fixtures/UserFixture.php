<?php declare(strict_types = 1);

namespace Database\Fixtures;

use App\Model\Auth\Form\Data\RegisterFormData;
use App\Model\Database\Entity\User;
use App\Model\Security\Passwords;
use App\Model\User\UserFacade;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{

	public function getOrder(): int
	{
		return 1;
	}

	public function load(ObjectManager $manager): void
	{
        /** @var UserFacade $userFacade */
        $userFacade = $this->container->getByType(UserFacade::class);

		foreach ($this->getUserData() as $userData) {
            $userFacade->create($userData);
		}
	}

	/**
	 * @return RegisterFormData[]
	 */
	protected function getUserData(): iterable
	{
        return [
            new RegisterFormData("test", "test@test.com", "password", "password")
        ];
	}

}