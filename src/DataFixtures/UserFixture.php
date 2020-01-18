<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $roles = $this->faker->getRoles();
        foreach ($roles as $index => $role) {
            $this->createMany(3, $index . '_user', function () use ($role){
                $userEntity = (new User())
                    ->setUsername($this->faker->unique()->userName)
                    ->setRoles([$role])
                    ->setFirstname($this->faker->firstName)
                    ->setLastname($this->faker->lastName)
                ;
                $userEntity
                    ->setGithub('https://github.com/' . $userEntity->getUsername())
                    ->setPassword($this->encoder->encodePassword($userEntity, 'password'))
                ;

                return $userEntity;
            });
        }

        $manager->flush();
    }
}
