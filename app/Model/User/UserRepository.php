<?php declare(strict_types=1);

namespace App\Model\User;

use App\Model\User\User;
use Doctrine\ORM\EntityRepository;

/**
 * @method User|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 * @extends EntityRepository<User>
 */
class UserRepository extends EntityRepository
{

}
