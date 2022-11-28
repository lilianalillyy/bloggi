<?php declare(strict_types=1);

/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
namespace App\Model\Database;

use App\Model\Post\Post;
use App\Model\Post\PostRepository;
use App\Model\Post\Rating\PostRating;
use App\Model\Post\Rating\PostRatingRepository;
use App\Model\User\User;
use App\Model\User\UserRepository;
use Doctrine\ORM\Decorator\EntityManagerDecorator;

/**
 * The entity manager.
 */
class EntityManager extends EntityManagerDecorator
{

  public function user(): UserRepository
  {
    $repository = $this->getRepository(User::class);

    assert($repository instanceof UserRepository);

    return $repository;
  }

  public function post(): PostRepository
  {
    $repository = $this->getRepository(Post::class);

    assert($repository instanceof PostRepository);

    return $repository;
  }

  public function postRating(): PostRatingRepository
  {
    $repository = $this->getRepository(PostRating::class);

    assert($repository instanceof PostRatingRepository);

    return $repository;
  }

}
