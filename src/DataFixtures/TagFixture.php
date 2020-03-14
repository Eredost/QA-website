<?php

namespace App\DataFixtures;


use App\DataFixtures\Provider\TagProvider;
use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $tags = TagProvider::getTags();
        $this->createMany(count($tags), 'main_tag', function ($count) use ($tags) {
            $tagEntity = (new Tag())
                ->setName($tags[$count]['name'])
                ->setBgColor($tags[$count]['bgColor'])
                ->setTextColor($tags[$count]['textColor'])
            ;

            return $tagEntity;
        });

        $manager->flush();
    }
}
