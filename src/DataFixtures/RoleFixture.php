<?php

namespace App\DataFixtures;


use App\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $roles = $this->faker->getRoles();
        $this->createMany(count($roles), 'main_role', function ($count) use ($roles){
            $roleEntity = (new Role())
                ->setName($roles[$count])
            ;

            return $roleEntity;
        });

        $manager->flush();
    }
}
