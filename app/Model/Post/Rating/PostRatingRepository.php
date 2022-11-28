<?php declare(strict_types=1);

namespace App\Model\Post\Rating;

use Doctrine\ORM\EntityRepository;

/**
 * @method PostRating|null find($id, ?int $lockMode = null, ?int $lockVersion = null)
 * @method PostRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostRating[] findAll()
 * @method PostRating[] findBy(array $criteria, array $orderBy = null, ?int $limit = null, ?int $offset = null)
 * @extends EntityRepository<PostRating>
 */
class PostRatingRepository extends EntityRepository
{

}
