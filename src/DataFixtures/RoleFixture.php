<?php

namespace App\DataFixtures;


use App\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $roles = $this->faker->getRoles();
        foreach ($roles as $role) {
            $roleEntity = (new Role())
                ->setName($role)
            ;
            $manager->persist($roleEntity);
        }

        $manager->flush();
    }
}
