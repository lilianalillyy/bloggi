<?php declare(strict_types=1);

namespace App\Model\Post\Comment;

use Doctrine\ORM\EntityRepository;

/**
 * @method PostComment|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method PostComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostComment[] findAll()
 * @method PostComment[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 * @extends EntityRepository<PostComment>
 */
class PostCommentRepository extends EntityRepository
{

}
