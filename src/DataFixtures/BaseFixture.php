<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\RoleProvider;
use App\DataFixtures\Provider\TagProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager $manager */
    private $manager;

    /** @var Generator $faker */
    protected $faker;

    /** @var array $referencesIndex */
    private $referencesIndex = array();

    protected abstract function loadData(ObjectManager $manager);

    /**
     * Method called when the doctrine:fixtures:load command is used
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker   = Factory::create('fr_FR');
        $this->faker->addProvider(new RoleProvider());
        $this->faker->addProvider(new TagProvider());

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

    /**
     * Returns all entities according to the group name created earlier with the createMany function
     *
     * $this->getReferences('main_user');
     *
     * @param string $groupName
     *
     * @return object[]
     *
     * @throws \InvalidArgumentException when the desired group name does not exist
     */
    protected function getReferences(string $groupName): array
    {
        if (!isset($this->referencesIndex[$groupName])) {
            $this->referencesIndex[$groupName] = [];
            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $groupName.'_') === 0) {
                    $reference = $this->getReference($key);
                    $this->referencesIndex[$groupName][] = $reference;
                }
            }
        }
        if (empty($this->referencesIndex[$groupName])) {

            throw new \InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"', $groupName));
        }

        return $this->referencesIndex[$groupName];
    }

    /**
     * Returns a single entity randomly according to those generated with the BaseFixture::getReferences() method
     *
     * $this->getRandomReference('main_user');
     *
     * @param string $groupName
     *
     * @return object
     *
     * @throws \InvalidArgumentException when the desired group name does not exist
     */
    protected function getRandomReference(string $groupName): object
    {
        $references = $this->getReferences($groupName);

        return $this->faker->randomElement($references);
    }
}
