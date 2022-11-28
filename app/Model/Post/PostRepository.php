<?php declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Post\Post;
use Doctrine\ORM\EntityRepository;

/**
 * @method Post|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[] findAll()
 * @method Post[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 * @extends EntityRepository<Post>
 */
class PostRepository extends EntityRepository
{

}
