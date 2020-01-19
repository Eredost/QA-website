<?php

namespace App\DataFixtures;


use App\Entity\Answer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AnswerFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(50, 'main_answer', function () {
            $questionEntity = $this->getRandomReference('main_question');
            $answerEntity = (new Answer())
                ->setContent($this->faker->paragraphs($this->faker->numberBetween(1, 4), true))
                ->setUser($this->getRandomReference('main_user'))
                ->setQuestion($questionEntity)
                ->setCreatedAt($this->faker->dateTimeBetween($questionEntity->getCreatedAt()))
            ;

            return $answerEntity;
        });

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getDependencies()
    {
        return [
            QuestionFixture::class,
        ];
    }
}
