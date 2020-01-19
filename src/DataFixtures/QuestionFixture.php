<?php

namespace App\DataFixtures;


use App\Entity\Question;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $tags = $this->getReferences('main_tag');
        $this->createMany(15, 'main_question', function () use ($tags) {
            $questionEntity = (new Question())
                ->setTitle($this->faker->words($this->faker->numberBetween(3, 7), true))
                ->setContent($this->faker->paragraphs($this->faker->numberBetween(2, 10), true))
                ->setUser($this->getRandomReference('main_user'))
                ->setCreatedAt($this->faker->dateTimeBetween('-1years'))
            ;

            $tagTotal = $this->faker->numberBetween(1, count($tags) - 1);
            for ($i = 0; $i < $tagTotal; $i++) {
                $questionEntity->addTag($this->faker->randomElement($tags));
            }

            return $questionEntity;
        });

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}
