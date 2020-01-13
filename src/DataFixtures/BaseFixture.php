<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager $manager */
    private $manager;

    /** @var Generator $faker */
    private $faker;

    /** @var array $referencesIndex */
    private $referencesIndex = array();

    protected abstract function loadData(ObjectManager $manager);

    public function loaded(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker   = Factory::create('fr_FR');

        $this->loadData($manager);
    }

    /**
     * Allows the creation of multiple entities more simply
     *
     * $this->createMany(10, 'main_user', function($count) {
     *     $user = (new User())
     *         ->setUsername(sprintf('user%d', $count))
     *         ->setPassword('password')
     *     ;
     *     return $user;
     * });
     *
     * @param int      $count     The number of entities that will be created
     * @param string   $groupName The name that will be used to reference the entity
     * @param callable $factory   Will add the necessary fields to the entity
     *
     * @return void
     *
     * @throws \LogicException when the entity created in the function was not returned
     */
    protected function createMany(int $count, string $groupName, callable $factory): void
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = $factory($i);

            if (null === $entity) {

                throw new \LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }
            $this->manager->persist($entity);
            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }
}
