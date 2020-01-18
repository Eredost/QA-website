<?php

namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $tags = $this->faker->getTags();
        $this->createMany(count($tags), 'main_tag', function ($count) use ($tags) {
            $tagEntity = (new Tag())
                ->setName($tags[$count])
            ;

            return $tagEntity;
        });

        $manager->flush();
    }
}
