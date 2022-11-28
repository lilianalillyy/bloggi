<?php declare(strict_types=1);

use App\Model\Database\EntityManager;
use App\Model\Post\Post;

/**
 * This script is an example of how you can manipulate the blog content
 * via PHP CLI scripts. Once you create an instance of the DI container,
 * you can access it's services, which includes the data-manipulation classes of Bloggi.
 *
 * For example the {User, Post, PostRating}Facade class to search the database, and then
 * the EntityManager to persist updated data.
 *
 * This example creates few Hello World posts with lorem ipsum content.
 *
 * @author Lilian
 */

require __DIR__ . '/../vendor/autoload.php';

$configurator = App\Kernel::boot();
$container = $configurator->createContainer();

$em = $container->getByType(EntityManager::class);

assert($em instanceof EntityManager);

for ($i = 0; $i < 5; $i++) {
  $post = (new Post())
    ->setTitle("Hello World no. $i")
    ->setPerex("Lorem ipsum dolor sit amet, consectetuer adipiscing elit.")
    ->setContent("Lorem ipsum dolor sit amet, consectetuer adipiscing elit. " .
      "Class aptent taciti sociosqu ad litora torquent per conubia nostra, " .
      "per inceptos hymenaeos. Mauris metus. Vestibulum erat nulla, ullamcorper nec, rutrum non, " .
      "nonummy ac, erat. Nullam dapibus fermentum ipsum. Cras elementum. Nulla accumsan, " .
      "elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo. Curabitur sagittis hendrerit ante."
    );

  $em->persist($post);
}

$em->flush();
