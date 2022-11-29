<?php declare(strict_types = 1);

namespace Database\Fixtures;

use App\Model\Post\Post;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends AbstractFixture
{

	public function getOrder(): int
	{
		return 1;
	}

	public function load(ObjectManager $manager): void
	{
		foreach ($this->getPostData() as $postData) {
            $post = (new Post())
                ->setTitle($postData['title'])
                ->setPerex($postData['perex'])
                ->setContent($postData['content']);
            $manager->persist($post);
		}

        $manager->flush();
	}

	/**
	 * @return array<string, mixed>[]
	 */
	protected function getPostData(): iterable
	{
        for ($i = 0; $i < 26; $i++) {
            yield [ "title" => $this->faker->text(64), "perex" => $this->faker->text(255), "content" => $this->faker->text(1024) ];
        }
	}

}