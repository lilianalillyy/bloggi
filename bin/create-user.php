<?php declare(strict_types=1);

use App\Model\Database\EntityManager;
use App\Model\User\User;

/**
 * This script is an example of how you can manipulate the blog content
 * via PHP CLI scripts. Once you create an instance of the DI container,
 * you can access it's services, which includes the data-manipulation classes of Bloggi.
 *
 * For example the {User, Post, PostRating}Facade class to search the database, and then
 * the EntityManager to persist updated data.
 *
 * This example creates a test user with the credentials test-user:test@user.com:password.
 *
 * @author Lilian
 */

require __DIR__ . '/../vendor/autoload.php';

$configurator = App\Kernel::boot();
$container = $configurator->createContainer();

$em = $container->getByType(EntityManager::class);

assert($em instanceof EntityManager);

$user = (new User())
  ->setUsername("test-user")
  ->setEmail("test@user.com")
  ->setPasswordHash("password");

$em->persist($user);

$em->flush();
